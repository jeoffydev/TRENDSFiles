<?php

    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 

    include_once("../../setup.php");  
    include_once("../../logcheck.php");

   

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
        $additionalOptions = 'additionalOptions';
        $productsPricingTableTemp = "productsPricingDEV";
        $pcTemp = 'productsCurrentDEV';

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
        $additionalOptions = 'additionalOptions';
        $productsPricingTableTemp = "productsPricing";
        $pcTemp = 'productsCurrent';
    } 

     
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

 
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



    $conn = Db::getInstance();  


    include_once("../SimpleImage.php");
    $serverPath = $_SERVER['DOCUMENT_ROOT'];
    $pathUrl1 = $serverPath.'/Images/ProductImg/';
    $pathUrl2 = $serverPath.'/Images/ProductImgSML/';

        /********* Component API  ******************/
        include("component_api.php"); 
        /********* Component API  ******************/
     

    
    if($request->option == 1){
        $id = $request->id;  
        
        //echo $id;
        //echo $request->modelName; 
        $req = $conn->prepare("SELECT * FROM ".$pcTemp." WHERE Prim =  :id "); 
        $req->execute(array('id' => $id));
        $results = $req->fetch();

        

        //clean html
        $results["Name"] = html_entity_decode($results["Name"], ENT_QUOTES);
        $results["Description"] = html_entity_decode($results["Description"], ENT_QUOTES);
        
        $results["Materials"] = html_entity_decode($results["Materials"], ENT_QUOTES);
        $results["Specifications"] = html_entity_decode($results["Specifications"], ENT_QUOTES);
        
        $results["Options"] = 3;
        $results['triggerEvent'] = false;
        $results['triggerEvent3'] = false;
        $results['triggerBranding'] = false;
         
        //Set Sizing
        if($results['sizingLine1'] == ""){
            $results['sizingLine1'] = null;
        }
        if($results['sizingLine2'] == ""){
            $results['sizingLine2'] = null;
        }
        if($results['sizingLine3'] == ""){
            $results['sizingLine3'] = null;
        }
        if($results['sizingLine4'] == ""){
            $results['sizingLine4'] = null;
        }

        //If sizingLine1 is not empty
       /* if($results['sizingLine1'] != null){
            $sizingLineOne = $results['sizingLine1'];
            $sizingLineArray = explode (",", $sizingLineOne);
            $sizingLineArray = str_replace('&nbsp;', '-', $sizingLineArray);
            $sizeCounter = count($sizingLineArray); 
            if($sizeCounter > 0){
                $results['triggerEvent'] = true;
            }
            $i = 0;
            foreach($sizingLineArray as $key => $value){ 
                if($i == 0){
                    $results['sizingLine1'] = $value;
                }  
                $i++;
            }  
            $results["sizeCount1"] = count($sizingLineArray); 
            unset($sizingLineArray[0]);
            $results["sizeArray"] =  $sizingLineArray; 
        }

        //If sizingLine2 is not empty
        if($results['sizingLine2'] != null){
            $sizingLineTwo = $results['sizingLine2'];
            $sizingLineArray2 = explode (",", $sizingLineTwo);
            $sizingLineArray2 = str_replace('&nbsp;', '-', $sizingLineArray2);
            $sizeCounter2 = count($sizingLineArray2); 
             
            $i = 0;
            foreach($sizingLineArray2 as $key => $value){ 
                if($i == 0){
                    $results['sizingLine2'] = $value;
                }  
                 
                $i++;
            }  
            unset($sizingLineArray2[0]);
            $results["sizeArray2"] =  $sizingLineArray2; 
        }
       
        
        //If sizingLine3 is not empty
        if($results['sizingLine3'] != null){
            $sizingLineThree = $results['sizingLine3'];
            $sizingLineArray3 = explode (",", $sizingLineThree);
            //print_r($sizingLineArray3);
            $sizingLineArray3 = str_replace('&nbsp;', '-', $sizingLineArray3);
            $sizeCounter3 = count($sizingLineArray3); 
            if($sizeCounter3 > 0){
                $results['triggerEvent3'] = true;
            }
            $i = 0;
            foreach($sizingLineArray3 as $key => $value){ 
                if($i == 0){
                  $results['sizingLine3'] = $value;
                }  
                $i++;
            }  
            $results["sizeCount3"] = count($sizingLineArray3); 
            unset($sizingLineArray3[0]);
            //print_r($sizingLineArray3);
            $results["sizeArray3"] =  $sizingLineArray3; 
        }

        //If sizingLine4 is not empty
        
        if($results['sizingLine4'] != null){
            $sizingLineFour = $results['sizingLine4'];
            $sizingLineArray4 = explode (",", $sizingLineFour);
            $sizingLineArray4 = str_replace('&nbsp;', '-', $sizingLineArray4);
            $sizeCounter4 = count($sizingLineArray4); 
            
            $i = 0;
            foreach($sizingLineArray4 as $key => $value){ 
                if($i == 0){
                    $results['sizingLine4'] = $value;
                }  
                $i++;
            }   
            unset($sizingLineArray4[0]);
            $results["sizeArray4"] =  $sizingLineArray4; 
        }  */
        
        //Branding 
        for($p = 1; $p <= 10; $p++){
            if($results['PrintType'.$p] != null || $results['PrintDescription'.$p] != null){
                
                $pt[]= $results['PrintType'.$p].','.$results['PrintDescription'.$p];
                $pts[]= $results['PrintType'.$p];
                $pds[]= html_entity_decode($results['PrintDescription'.$p]);
            } 
        }
        $results['PrintTypeCount'] = count($pt); 
        if($results['PrintTypeCount'] != 0){
            $results['triggerBranding'] = true; 
            //print_r($pts);
            $ptsFin =array_combine(range(1, count($pts)), $pts);
            $pdsFin =array_combine(range(1, count($pds)), $pds);
            $results['printTypes'] = $ptsFin;
            $results['PrintDescriptions'] = $pdsFin;
        }
        
        if($results['ColorSearch'] || !$results['ColorSearch']){
            //$results['ColorSearch']
            $reqs = $conn->prepare("SELECT * FROM ".$colourSearchTable." ORDER BY colourOrder ASC "); 
            $reqs->execute();
            $resultColours = $reqs->fetchAll();
            $rsCount =  count($resultColours);
            
            $nameSearch = array();
            $nameTitle = array();
            $colors = explode(" ", strtolower($results['ColorSearch'])); 
            //print_r($colors);
            $results['ColorSearchArray']  = $colors;  

            $cs = 0;
            foreach($resultColours as $key => $value){
                //echo $value['nameTitle'] . " => " .$value['nameSearch'];
                $nameTitle =$value['nameTitle'];
                $nameSearch = strtolower($value['nameSearch']);
                $hexCode =  $value['hexCode'];
                if (in_array($nameSearch, $colors)) {
                    $arrColours[] = [$nameTitle, $nameSearch, $cs, true, $hexCode];
                }else{
                    $arrColours[]  = [$nameTitle, $nameSearch, $cs,  false, $hexCode];
                } 
                $cs++; 
            }
           // print_r($arrColours);
            //$arrColours  = array_combine($nameTitle, $nameSearch);
             $results['ColorSearchVariables'] = $arrColours;   
           /* $cs = 0;
            foreach($colors as $col){ 
               $results['ColorSearchArray']  = $col; 
               $cs++;
            } */
            
            
        }


        
        

        if($results['Code']){
            $reqPrice = $conn->prepare("SELECT * FROM ".$productsPricing." WHERE Coode = '".$results['Code']."' ORDER BY PriceOrder ASC "); 
            $reqPrice->execute();
            $resultPricing = $reqPrice->fetchAll();
             
            //$results["AdditionalText"] = html_entity_decode($resultPricing["AdditionalText"]);
             //print_r($resultPricing);
            if($resultPricing > 0){ 
                $results['pricingCount'] = count($resultPricing);
                $results['pricingLoop'] =  $resultPricing; 
                $results['NewPricingLoop'] =  []; 
                $countPriceLess = $results['pricingCount'] - 1;
                for($prc = 0; $prc <=  $countPriceLess; $prc++){
                   // echo $prc;
                    $results['pricingLoopAdditionalText'][$prc] = html_entity_decode($resultPricing[$prc]["AdditionalText"]);
                }

                


                $priceC= 1;
                for($pr=0; $pr <= $countPriceLess; $pr++ ){ 
                    //echo  $priceC;
                    $resultPricingAdditionals[]  = array( 
                        "1"=> $resultPricing[$pr]['AdditionalCostDesc1'] ?  array($resultPricing[$pr]['AdditionalCostDesc1'], $resultPricing[$pr]['AdditionalCost1'], $resultPricing[$pr]['SetupCharge1']) : null,
                        "2"=> $resultPricing[$pr]['AdditionalCostDesc2'] ?  array($resultPricing[$pr]['AdditionalCostDesc2'], $resultPricing[$pr]['AdditionalCost2'], $resultPricing[$pr]['SetupCharge2']): null,
                        "3"=> $resultPricing[$pr]['AdditionalCostDesc3'] ?  array($resultPricing[$pr]['AdditionalCostDesc3'], $resultPricing[$pr]['AdditionalCost3'], $resultPricing[$pr]['SetupCharge3']): null,
                        "4"=> $resultPricing[$pr]['AdditionalCostDesc4'] ?  array($resultPricing[$pr]['AdditionalCostDesc4'], $resultPricing[$pr]['AdditionalCost4'], $resultPricing[$pr]['SetupCharge4']): null,
                        "5"=> $resultPricing[$pr]['AdditionalCostDesc5'] ?  array($resultPricing[$pr]['AdditionalCostDesc5'], $resultPricing[$pr]['AdditionalCost5'], $resultPricing[$pr]['SetupCharge5']) : null,
                        "6"=> $resultPricing[$pr]['AdditionalCostDesc6'] ?  array($resultPricing[$pr]['AdditionalCostDesc6'], $resultPricing[$pr]['AdditionalCost6'], $resultPricing[$pr]['SetupCharge6']): null,
                        "7"=> $resultPricing[$pr]['AdditionalCostDesc7'] ?  array($resultPricing[$pr]['AdditionalCostDesc7'], $resultPricing[$pr]['AdditionalCost7'], $resultPricing[$pr]['SetupCharge7']): null,
                        "8"=> $resultPricing[$pr]['AdditionalCostDesc8'] ?  array($resultPricing[$pr]['AdditionalCostDesc8'], $resultPricing[$pr]['AdditionalCost8'], $resultPricing[$pr]['SetupCharge8']): null,
                        "9"=> $resultPricing[$pr]['AdditionalCostDesc9'] ?  array($resultPricing[$pr]['AdditionalCostDesc9'], $resultPricing[$pr]['AdditionalCost9'], $resultPricing[$pr]['SetupCharge9']): null,
                        "10"=> $resultPricing[$pr]['AdditionalCostDesc10'] ?  array($resultPricing[$pr]['AdditionalCostDesc10'], $resultPricing[$pr]['AdditionalCost10'], $resultPricing[$pr]['SetupCharge10']): null,
                        "11"=> $resultPricing[$pr]['AdditionalCostDesc11'] ?  array($resultPricing[$pr]['AdditionalCostDesc11'], $resultPricing[$pr]['AdditionalCost11'], $resultPricing[$pr]['SetupCharge11']): null,
                        "12"=> $resultPricing[$pr]['AdditionalCostDesc12'] ?  array($resultPricing[$pr]['AdditionalCostDesc12'], $resultPricing[$pr]['AdditionalCost12'], $resultPricing[$pr]['SetupCharge12']): null,
                    );
                    $priceC++;   
                }
                $results["Additionals"] = $resultPricingAdditionals;  
                $results["AdditionalsCount"] = count($resultPricingAdditionals);  

                //echo $results["AdditionalsCount"];
                 //print_r( $resultPricing["Additionals"]);
                //${"PrintType" . $key} = $val;  
            }  

        }




        /* NEW Additional Cost Options ***************/

        /************* PLEASE CHANGE THE productsCurrentDEV to LIVE IF needed on LIVE  *****************/



        if($results['Code']){


            //Get Additional Options
            $reqAdditionalOptions = $conn->prepare("SELECT * FROM ".$additionalOptions." WHERE ProductCode = '".$results['Code']."' ORDER BY orderRow ASC "); 
            $reqAdditionalOptions->execute();
            $arrayAdditionalPricingTypes  = $reqAdditionalOptions->fetchAll();

            //Count
            $results["UpgradeAddOptionsCount"] = count($arrayAdditionalPricingTypes);

            if(count($arrayAdditionalPricingTypes) > 0){
                 $results["UpgradeAddOptionsList"] = $arrayAdditionalPricingTypes;

                 $brandAddsPT = 0;
                 foreach($arrayAdditionalPricingTypes as $upgradeRow){
                    $upgradeAddsPricing[] = $upgradeRow['PricingType'];

                    $brandAddsPTResults[] =  $brandAddsPT;
                    $brandAddsPT++;
                 }

                 $results['UpgradePricingTypeBrandCountArray'] = $brandAddsPTResults;
                 $results['UpgradePricingTypeUniqueOne'] = array_unique($upgradeAddsPricing);

                 rsort($results['UpgradePricingTypeUniqueOne']); // Order

                 /////////////////////////NEew
                 /////////////////////////////Get PricingType in ProductsPricing Table
                 $reqPTypes = $conn->prepare("SELECT * FROM ".$productsPricingTableTemp." WHERE Coode = '".$results['Code']."' ORDER BY PriceOrder ASC "); 
                 $reqPTypes->execute();
                 $arrayAdditionalPTypes  = $reqPTypes->fetchAll();

                 foreach($arrayAdditionalPTypes as $rowptyes){
                    $upgradePTypesOrder[] = $rowptyes['PricingType']; 
                 } 
                 $results['UpgradePricingTypesOrder'] = array_unique($upgradePTypesOrder);
                 /////////////////////////////Get PricingType in ProductsPricing Table
                 /////////////////////////NEew
                 
                 //Get the AdditionalOptions data
                 $bb = 0;
                 //Replaced $results['UpgradePricingTypeUniqueOne'] to $results['UpgradePricingTypesOrder']
                 foreach($results['UpgradePricingTypesOrder'] as $key => $value){
                    //NZD && AUD
                    $reqB = $conn->prepare("SELECT  *  FROM ".$additionalOptions." WHERE     ProductCode = '".$results['Code']."' AND PricingType = '".$value."'    ORDER BY  orderRow ASC   ");  
                    $reqB->execute();
                    $resultsFilteredBranding[$bb] = $reqB->fetchAll();  
                    
                    $bi = 0;
                    foreach($resultsFilteredBranding[$bb] as $rowAdds){
                       // print_r($rowAdds['additionalOptionCategory']);

                      // print_r($resultsFilteredBranding[$bb][$bi]['additionalOptionCategory']);

                        if($resultsFilteredBranding[$bb][$bi]['additionalOptionCategory'] == "DO"){
                            $resultsFilteredBranding[$bb][$bi]['additionalOptionCategory'] = "Decoration Option";
                        }
                        if($resultsFilteredBranding[$bb][$bi]['additionalOptionCategory'] == "OE"){
                            $resultsFilteredBranding[$bb][$bi]['additionalOptionCategory'] = "Optional Extra";
                        }
                        if($resultsFilteredBranding[$bb][$bi]['additionalOptionCategory'] == "DCOE"){
                            $resultsFilteredBranding[$bb][$bi]['additionalOptionCategory'] = "Decoration Charge on Optional Extra";
                        } 

                        $bi++;
                    }
                    
                    $bb++;
                 }

                 $results['UpgradeFilteredAdditionalList'] = $resultsFilteredBranding; 

                
            }

            
            // Get pricing
             /************* PLEASE CHANGE THE productsCurrentDEV to LIVE IF needed on LIVE  *****************/
            
             
             $columns = " ".$productsPricingTableTemp.".index, Coode, Naame, Currency, PricingType, PriceOrder, LessThanMOQ, PrimaryPriceDes, PriceType,  Quantity1, Quantity2, Quantity3, Quantity4, Quantity5, Quantity6,  
             Price1, Price2, Price3, Price4, Price5, Price6, AdditionalText, Converted";

            $reqPricingUpgrade = $conn->prepare("SELECT ".$columns."  FROM  ".$productsPricingTableTemp."  WHERE Coode = '".$results['Code']."'  AND Converted = 1 ORDER BY PriceOrder ASC  "); 
            $reqPricingUpgrade->execute(); 
            $arrayPricingLists = $reqPricingUpgrade->fetchAll();
           
            $results["UpgradePricingCount"] = count($arrayPricingLists);

            $arrayCompareCurrency = array(0=>'NZD', 1=>'AUD', 2=>'SGD', 3=>'MYR' );

            if(count($arrayPricingLists) > 0){
                $results['UpgradePricingList']  = $arrayPricingLists;
                foreach($arrayPricingLists as $upgradePriceRow){
                    $upgradePriceTypeRow[] = $upgradePriceRow['PricingType'];
                }   
                $results['UpgradePricingTypeUniqueTwo'] = array_unique($upgradePriceTypeRow);  
                $xk= 0;
                foreach($results['UpgradePricingTypeUniqueTwo'] as $key => $value){
                    //NZD && AUD
                    $reqCur = $conn->prepare("SELECT ".$columns."  FROM ".$productsPricingTableTemp." WHERE     Coode = '".$results['Code']."' AND PricingType = '".$value."'   ORDER BY  Currency DESC    ");  
                    $reqCur->execute();
                    $resultsFilteredPricing[$xk] = $reqCur->fetchAll(); 

                     
                    
                     //Get Currencies and Filtered ********************************************
                      
                    if(count($resultsFilteredPricing[$xk]) > 0){ 
                        $xc = 0;
                        foreach($resultsFilteredPricing[$xk] as $newRow){
                            $getCurrency[$xc] = $newRow['Currency'];
                            $xc++; 
                        }   
                        $resultCurrencyFiltered =array_diff($arrayCompareCurrency, $getCurrency);
                        //print_r($resultCurrencyFiltered);
                       
                        $cr = 0;
                        $countPr = count($resultsFilteredPricing[$xk]);
                        foreach($resultCurrencyFiltered as $currs){

                                $countPrFinal = $countPr + $cr;
                                //echo $currs. " => " .$countPrFinal;
                                $resultsFilteredPricing[$xk][$countPrFinal] = array(
                                    "index" => 0,
                                    "Coode"=> $results['Code'],   
                                    "Currency"=> $currs,  
                                    "Converted"=> 1, 
                                    "LessThanMOQ" => $resultsFilteredPricing[$xk][$cr]['LessThanMOQ'], 
                                    "Naame"=>  $results["Name"], 
                                    "PricingType"=> $value, 
                                    "PrimaryPriceDes" =>   $resultsFilteredPricing[$xk][$cr]['PrimaryPriceDes'],
                                    "PriceType" =>  $resultsFilteredPricing[$xk][$cr]['PriceType'],
                                    "Quantity1" => $resultsFilteredPricing[$xk][$cr]['Quantity1'],
                                    "Quantity2" => $resultsFilteredPricing[$xk][$cr]['Quantity2'],
                                    "Quantity3" => $resultsFilteredPricing[$xk][$cr]['Quantity3'],
                                    "Quantity4" => $resultsFilteredPricing[$xk][$cr]['Quantity4'],
                                    "Quantity5" => $resultsFilteredPricing[$xk][$cr]['Quantity5'],
                                    "Quantity6" => $resultsFilteredPricing[$xk][$cr]['Quantity6'],
                                    "Price1" => 0.00,
                                    "Price2" => 0.00,
                                    "Price3" => 0.00,
                                    "Price4" => 0.00,
                                    "Price5" => 0.00,
                                    "Price6" => 0.00,
                                    "Status" => "New"


                                );

                            $cr++;
                        }   
                    }   
                    //Get Currencies and Filtered ********************************************

                    $resultsFilterKeys[] =  $xk;

                    $xk++;
                }

               
                $results['UpgradeFilteredPricing'] = $resultsFilteredPricing;
                $results['UpgradeFilterKeys'] =  $resultsFilterKeys;
            }
            // Get converted value
            $getConvertedValue = 0;
            foreach($arrayPricingLists as $rowArrPrice){
                if($rowArrPrice['Converted'] == 1){
                    $getConvertedValue  = $rowArrPrice['Converted'];
                } 
            }
            $results['UpgradeIfConverted'] = $getConvertedValue;

            //Get the Component API COde 
            $results['UpgradecomponentAPI'] =  Components($results['Code']);

        }

        

       
        /* NEW Additional Cost Options ***************/




       
        /* Images */
        if($results['Code']){

                $reqImage = $conn->prepare("SELECT * FROM ".$pcTemp." WHERE Prim =  :id "); 
                $reqImage->execute(array('id' => $id));
                $resultsImg = $reqImage->fetch();

               

                if($resultsImg["ImageCount"] == 0){ 
                    $ImgZero = $results["Code"].'-0.jpg';
                    $ImgPath = $_SERVER['DOCUMENT_ROOT']."/Images/ProductImg/".$ImgZero;

                    if(file_exists($ImgPath)) {
                        $ImgPath = 1; 
                        $results["ImagesExists"] = 1;
                        //$arrs[] = $results["Code"].'-0.jpg'; 
                        $reqs = $conn->prepare("SELECT * FROM ".$segmentStockCode." WHERE FGCode =  :code AND Image = :img "); 
                        $reqs->execute(array('code' => $results["Code"], 'img' => 0));
                        $resultSegmentStockCode = $reqs->fetch(); 

                        $arrs[] = array('key'=> $resultSegmentStockCode['StockCode'], 'value'=> $resultsImg["Code"].'-0.jpg', 'cols'=> $resultSegmentStockCode['Colour'],  'imgNum' => 0, 'Caption' => $resultSegmentStockCode["Caption"]); 
                        $results["ImagesLoop"] = $arrs;
                        $results["ImageCountNew"] = 1;
                    }else{
                        
                        $results["ImagesExists"] = 0;
                        $results["ImagesLoop"] = ''; 
                        $results["ImageCountNew"] = 0;
                    } 

                }else{
                    for($i = 0; $i <= $resultsImg["ImageCount"]; $i++ ){ 
                        $reqs = $conn->prepare("SELECT * FROM ".$segmentStockCode." WHERE FGCode =  :code AND Image = :img "); 
                        $reqs->execute(array('code' => $results["Code"], 'img' => $i));
                        $resultSegmentStockCode = $reqs->fetch(); 
                        $arrs[] = array('key'=> $resultSegmentStockCode['StockCode'], 'value'=> $resultsImg["Code"].'-'.$i.'.jpg', 'cols'=> $resultSegmentStockCode['Colour'], 'imgNum' => $i, 'Caption' => $resultSegmentStockCode["Caption"]); 
                    }
                    $results["ImagesLoop"] = $arrs;
                    $results["ImageCountNew"] = 1 + $resultsImg["ImageCount"];
                } 

                /* Segment code */
                $reqStock = $conn->prepare("SELECT *   FROM  ".$productsStock." WHERE Code =  '".$results["Code"]."' AND SortCode != 0 ORDER BY SortCode ASC "); 
                $reqStock->execute();
                $resultsStock = $reqStock->fetchAll();
                
                if($resultsStock){
                    $json_data=array();
                    for($i = 0; $i < count($resultsStock); $i++ ){
                        $json_arrayS['Code']=$resultsStock[$i]['Code'];    
                        $json_arrayS['PartName']=   utf8_encode($resultsStock[$i]['PartName']);    // Edit this or Filter      
                        $json_arrayS['ComponentCode']=$resultsStock[$i]['ComponentCode'];    
                        $json_arrayS['Quantity']=$resultsStock[$i]['Quantity'];    
                        $json_arrayS['DueDate']=$resultsStock[$i]['DueDate'];    
                        $json_arrayS['SortCode']=$resultsStock[$i]['SortCode'];    
                        $json_arrayS['BlurbNotes']=$resultsStock[$i]['BlurbNotes'];    
                        $json_arrayS['PmsCode']=$resultsStock[$i]['PmsCode'];   
                        
                        array_push($json_data, $json_arrayS);
                    } 

                    $results["productStocks"] = $json_data;
                    
                }else{
                    $results["productStocks"] = array();
                }

                /* CoulourSearch Ready */
                $reqColour = $conn->prepare("SELECT * FROM ".$colourSearchTable." ORDER BY colourOrder ASC "); 
                $reqColour->execute();
                $resultsColours = $reqColour->fetchAll();
                //$results["coloursSelects"] = $resultsColour;
                $resultsColourCount = count($resultsColours) - 1;
                
                for($c = 0; $c <= $resultsColourCount; $c++){
                    $nameSearch = strtolower($resultsColours[$c]['nameSearch']);
                    $printColours[$nameSearch] = $nameSearch;
                } 
                $results["coloursSelects"] = $printColours;
                
                /* $results["coloursSelects"] = array(
                    'silver'=>'silver',
                    'natural'=>'natural',
                    'white'=>'white',
                    'yellow'=>'yellow',
                    'orange'=>'orange',
                    'pink'=>'pink',
                    'red'=>'red',
                    'bright green'=>'bright green',
                    'green'=>'green',
                    'teal'=>'teal',
                    'light blue'=>'light blue',
                    'blue'=>'blue',
                    'purple'=>'purple',
                    'black'=>'black',
                ); */
        }        

        /* Images */
        
        //checkUSerCMS
        $checkUserID = $request->checkUserID;
        $checkUserCMS = $conn->prepare("SELECT * FROM ".$pageTrackerTable." WHERE userID != :userids AND codeTrack = :codes "); 
        $checkUserCMS->execute(array('codes' => $results['Code'], 'userids' => $checkUserID));
        $resultUserCMS = $checkUserCMS->fetch(); 
        if($resultUserCMS){ 
            $resUserCMS = $conn->prepare("SELECT * FROM ".$userData." WHERE userID = :useridCheck  "); 
            $resUserCMS->execute(array('useridCheck' => $resultUserCMS['userID']));
            $resultCheckEmailUser = $resUserCMS->fetch(); 
            $results["resultCheckEmailUser"] = $resultCheckEmailUser['userEmail'];  
            $results["resultCheckEdited"] = 1; 
         }else{
            $results["resultCheckEmailUser"] = 0;  
            $results["resultCheckEdited"] = 0; 
         } 

         //  freightOption select
        $reqFreight = $conn->prepare("SELECT * FROM ".$freightOption."  ORDER BY Prim ASC "); 
        $reqFreight->execute();
        $resultFreight = $reqFreight->fetchAll(); 
        $results['selectFreightOptions'] = $resultFreight;

        $someJSON = json_encode($results);
        echo $someJSON; 
      
    }
    //Update the fields
    if($request->option == 2){
        
        $field = $request->id;  
        $Prim = $request->Prim; 
        $Val = $request->Val; 
        
        $newVal = htmlspecialchars($Val, ENT_QUOTES);

        $sql = "UPDATE ".$pc." SET  ".$field." ='".$newVal."', updated = NOW()    WHERE Prim ='".$Prim."'";
        $update = $conn->query($sql);
        if($update){
            echo '1';  
       }else{
            echo '0';  
       } 
    }

 
    //Update the whole form
    if($request->Options == 3){ 
        $data = array();
        $error = array();
        $Prim = $request->Prim;
        $Name = cleanValue2($request->Name);
        $Code = $request->Code; 
        $Status = $request->Status;
        $Size = $request->Size;
        $Dimension1 = $request->Dimension1;
        $Dimension2 = $request->Dimension2;
        $Dimension3 = $request->Dimension3; 
        $sizingLine1 = $request->sizingLine1;
        $sizingLine2 = $request->sizingLine2;
        $sizingLine3 = $request->sizingLine3;
        $sizingLine4 = $request->sizingLine4; 

        //If SizeArray
       /* if($request->sizeArray){ 
            $sizingLine1 = getSizingValues($request->sizeArray, $sizingLine1, 1);  
        }  
        if($request->sizeArray2){ 
            $sizingLine2 = getSizingValues($request->sizeArray2, $sizingLine2, 1);  
        }
        if($request->sizeArray3){ 
            $sizingLine3 = getSizingValues($request->sizeArray3, $sizingLine3, 1);  
        }  
        if($request->sizeArray4){ 
            $sizingLine4 = getSizingValues($request->sizeArray4, $sizingLine4, 1);  
        }
        

        //If SizingVal
        if($request->sizingValA){ 
            $sizingLine1 = getSizingValues($request->sizingValA, $sizingLine1); 
        } 
        if($request->sizingValB){
            $sizingLine2 = getSizingValues($request->sizingValB, $sizingLine2);  
        } 
        if($request->sizingValC){ 
            $sizingLine3 = getSizingValues($request->sizingValC, $sizingLine3); 
        }
        if($request->sizingValD){
            $sizingLine4 = getSizingValues($request->sizingValD, $sizingLine4);  
        } */


        $sizingLine1 = $sizingLine1;
        $sizingLine2 = $sizingLine2;
        $sizingLine3 = $sizingLine3;
        $sizingLine4 = $sizingLine4;
        //$Description = $request->Description;
        $Description = cleanValue($request->Description);
        $Materials = cleanValue($request->Materials);
        $Specifications = cleanValue($request->Specifications); 
        $Category1 = $request->Category1;
        $Category2 = $request->Category2;
        $Category3 = $request->Category3;
        $Category4 = $request->Category4;
        $Category5 = $request->Category5;
        $Category6 = $request->Category6;
        $Category7 = $request->Category7;
        $Category8 = $request->Category8; 

        //PrintTypes
        $PrintType1 = null;
        $PrintType2 = null;
        $PrintType3 = null;
        $PrintType4 = null;
        $PrintType5 = null;
        $PrintType6 = null;
        $PrintType7 = null;
        $PrintType8 = null;
        $PrintType9 = null;
        $PrintType10 = null;

        if($request->printTypes){
             //print_r($request->printTypes); 
             $pTypes =  $request->printTypes; 
             foreach($pTypes as $key => $value){ 
                 $PrintTypeArray[$key] = $value; 
             }   
             foreach($PrintTypeArray as $key => $val){  
                  ${"PrintType" . $key} = $val; 
             } 
        }

        //PrintDescriptions
        $PrintDescription1 = null;
        $PrintDescription2 = null;
        $PrintDescription3 = null;
        $PrintDescription4 = null;
        $PrintDescription5 = null;
        $PrintDescription6 = null;
        $PrintDescription7 = null;
        $PrintDescription8 = null;
        $PrintDescription9 = null;
        $PrintDescription10 = null;

        if($request->PrintDescriptions){ 
            //print_r($request->printTypes); 
            $pDescriptions =  $request->PrintDescriptions; 
            foreach($pDescriptions as $key => $value){ 
                $PrintDescriptionArray[$key] = $value; 
            }   
            foreach($PrintDescriptionArray as $key => $val){  
                 ${"PrintDescription" . $key} = cleanValue($val); 
            } 
        }
        
        //If colourSearch
        if($request->selectedCheckedOneValues){ 
            $coloursArr = $request->selectedCheckedOneValues;
            $coloursArrExplode = preg_replace('/[,]+/', ' ', trim($coloursArr));
            $ColorSearch = $coloursArrExplode; 
        }
        /*
        $PrintType1 = $request->PrintType1;
        $PrintDescription1 = cleanValue($request->PrintDescription1);
        $PrintType2 = $request->PrintType2;
        $PrintDescription2 = cleanValue($request->PrintDescription2);
        $PrintType3 = $request->PrintType3;
        $PrintDescription3 = cleanValue($request->PrintDescription3);
        $PrintType4 = $request->PrintType4;
        $PrintDescription4 = cleanValue($request->PrintDescription4);
        $PrintType5 = $request->PrintType5;
        $PrintDescription5 = cleanValue($request->PrintDescription5);
        $PrintType6 = $request->PrintType6;
        $PrintDescription6 = cleanValue($request->PrintDescription6);
        $PrintType7 = $request->PrintType7;
        $PrintDescription7 = cleanValue($request->PrintDescription7);
        $PrintType8 = $request->PrintType8;
        $PrintDescription8 = cleanValue($request->PrintDescription8);
        $PrintType9 = $request->PrintType9;
        $PrintDescription9 = cleanValue($request->PrintDescription9);
        $PrintType10 = $request->PrintType10;
        $PrintDescription10 = cleanValue($request->PrintDescription10);  */
        $Colours = $request->Colours; 
        $ColoursSecondary = $request->ColoursSecondary; 
        $ThirdColours = $request->ThirdColours;
        //$ColorSearch = $request->ColorSearch; 
        $Packing = $request->Packing; 
        $cartonLength = $request->cartonLength; 
        $cartonWidth = $request->cartonWidth; 
        $cartonHeight = $request->cartonHeight; 
        $cartonWeight = $request->cartonWeight; 
        $cartonQuantity = $request->cartonQuantity;  
        $Keywords = str_replace(["`", "'"], '', $request->Keywords);
        $Video = $request->Video;
        $StockComment = $request->StockComment; 
        $FullColour = $request->FullColour;
        $IsMixMatch = $request->IsMixMatch;
        $Active = $request->Active;
        $ExclusiveItem = $request->ExclusiveItem;
        $visualsAvailable = $request->visualsAvailable;
        $featuredItem = $request->featuredItem;
        $HitSKU = $request->HitSKU; 
        $IsIndent = $request->IsIndent;
        $IsIndentExpress = $request->IsIndentExpress;
        $availNZ = $request->availNZ;
        $availAU = $request->availAU;
        $Eco = $request->Eco;
        $Recycle = $request->Recycle;
        $OnDemandStock = $request->OnDemandStock;


        //Save update of Despatch and freight options
        $despatchLocation = $request->despatchLocation;
        if(count($request->freightNumberSelected) > 0){
             $freightString = implode(",", $request->freightNumberSelected);
            
             $freightCheck = substr($freightString, 0, 1);
             if($freightCheck == ","){ 
                 $freightString = substr($freightString, 1); 
             } 
             $freightOptions = $freightString; 
             
        }else{
            $freightOptions = null;
        }
         

        //Validate
  
        if(empty($Name)){
            $error["Name"] = "Name is required";
        }
        if(empty($Code)){
            $error["Code"] = "Code is required";
        }
        if($Code){
            if(filter_var($Code, FILTER_VALIDATE_INT) === false){
                $error["Code"] = "Code must be an integer";
            }   
        } 

        //Carton's Validation
        if($cartonLength || $cartonWidth || $cartonHeight || $cartonQuantity){ 
            if(filter_var($cartonLength, FILTER_VALIDATE_INT) === false){
                $error["CartonLength"] = "Carton Length must be an integer";
            }  
            if(filter_var($cartonWidth, FILTER_VALIDATE_INT) === false){
                $error["CartonWidth"] = "Carton Width must be an integer";
            }  
            if(filter_var($cartonHeight, FILTER_VALIDATE_INT) === false){
                $error["CartonHeight"] = "Carton Height must be an integer";
            }  
            if(filter_var($cartonQuantity, FILTER_VALIDATE_INT) === false){
                $error["CartonQuantity"] = "Carton Quantity must be an integer";
            }  
        }

         //CHange Log
         if($request->disableChange == 1){

            $changeType = $request->changeType;
            $ChangeDescription = cleanValue($request->ChangeDescription); 
            if(empty($changeType)){
                $error["changeType"] = "Change type is required";
            }
            if(empty($ChangeDescription)){
                $error["ChangeDescription"] = "Change log description Type is required";
            } 
 
        }

        

        if(!empty($error)) {
            $data["error"] = $error;
            $data["message"] = " Please check your entry ";   
        } else {

             //releaseDate
             $origStatus = $request->origStatus;
             if($origStatus == 'X' && $Status == 'N'){
                 date_default_timezone_set('Pacific/Auckland');
                 $releaseDate = date("Y-m-d H:i:s");
                 $releaseQuery = "releaseDate = '".$releaseDate."', ";
             }else{
                 $releaseQuery = " ";
             } 
 
          
            //$newVal = htmlspecialchars($Val, ENT_QUOTES); 
             $sql = "UPDATE ".$pcTemp." SET  Code ='".$Code."', Name ='".$Name."', Status ='".$Status."',  Size ='".$Size."',  
            Dimension1 = '".$Dimension1."', Dimension2 = '".$Dimension2."', Dimension3 = '".$Dimension3."', 
            sizingLine1 = '".$sizingLine1."',  sizingLine2 = '".$sizingLine2."', sizingLine3 = '".$sizingLine3."',  sizingLine4 = '".$sizingLine4."', 
            Description = '".$Description."',  Materials = '".$Materials."',  Specifications = '".$Specifications."',  
            Category1 = '".$Category1."', Category2 = '".$Category2."', Category3 = '".$Category3."',  Category4 = '".$Category4."',  Category5 = '".$Category5."',  Category6 = '".$Category6."',  Category7 = '".$Category7."',  Category8 = '".$Category8."',
            PrintType1 = '".$PrintType1."', PrintType2 = '".$PrintType2."', PrintType3 = '".$PrintType3."', PrintType4 = '".$PrintType4."',  PrintType5 = '".$PrintType5."', 
            PrintType6 = '".$PrintType6."', PrintType7 = '".$PrintType7."', PrintType8 = '".$PrintType8."', PrintType9 = '".$PrintType9."',  PrintType10 = '".$PrintType10."', 
            PrintDescription1 = '".$PrintDescription1."', PrintDescription2 = '".$PrintDescription2."', PrintDescription3 = '".$PrintDescription3."', PrintDescription4 = '".$PrintDescription4."', PrintDescription5 = '".$PrintDescription5."',
            PrintDescription6 = '".$PrintDescription6."', PrintDescription7 = '".$PrintDescription7."', PrintDescription8 = '".$PrintDescription8."', PrintDescription9 = '".$PrintDescription9."', PrintDescription10 = '".$PrintDescription10."',
            Colours ='".$Colours."', ColoursSecondary ='".$ColoursSecondary."', ThirdColours ='".$ThirdColours."',  ColorSearch ='".$ColorSearch."',
            Packing ='".$Packing."', cartonLength ='".$cartonLength."', cartonWidth ='".$cartonWidth."', cartonHeight ='".$cartonHeight."', cartonWeight ='".$cartonWeight."', cartonQuantity ='".$cartonQuantity."',
            Keywords ='".$Keywords."', Video ='".$Video."', StockComment ='".$StockComment."', 
            FullColour ='".$FullColour."', IsMixMatch ='".$IsMixMatch."', Active ='".$Active."', ExclusiveItem ='".$ExclusiveItem."', visualsAvailable ='".$visualsAvailable."', 
            featuredItem ='".$featuredItem."', HitSKU ='".$HitSKU."', IsIndent ='".$IsIndent."', IsIndentExpress ='".$IsIndentExpress."', availNZ = '".$availNZ."', availAU = '".$availAU."',  Eco = '".$Eco."', Recycle = '".$Recycle."',
            despatchLocation  ='".$despatchLocation."', freightOptions ='".$freightOptions."', OnDemandStock = '".$OnDemandStock."',
            $releaseQuery
            updated = NOW()    WHERE Prim ='".$Prim."'";
            $update = $conn->query($sql);  

            
            



             //Pricing Removed
            //print_r($request->pricingLoop); 
            
             

            // PRODUCT STOCK PMS
            if($request->productStocks){
                //print_r($request->productStocks);
                $arrayStockCount = count($request->productStocks);
                if($arrayStockCount){
                    $arrayStockCount = $arrayStockCount - 1;
                } 
                for($ps = 0; $ps <= $arrayStockCount; $ps++){  
                    $arrayStocks = (array)$request->productStocks[$ps]; 
                    //if($request->productStocks[$ps]->PmsCode){
                        //print_r($request->productStocks[$ps]);

                        $ComponentCode =  $request->productStocks[$ps]->ComponentCode;
                        $ItemCode =  $request->productStocks[$ps]->Code;
                        $PartName = $request->productStocks[$ps]->PartName;
                        $PmsCode = $request->productStocks[$ps]->PmsCode;
                            
                        $sqlStockUpdate = "UPDATE ".$productsStock." SET  
                            PmsCode = '".$PmsCode."' 
                            WHERE   ComponentCode  = '".$ComponentCode."' AND Code = '".$ItemCode."' "; 
                        $sqlStockUpdateDone = $conn->query($sqlStockUpdate);    
                        //echo $request->productStocks[$ps]->PartName."/".$request->productStocks[$ps]->ComponentCode."/".$request->productStocks[$ps]->PmsCode;
                   // }  
                }
            }  
           // PRODUCT STOCK PMS


           //CHange log of Pricing
            //print_r($request->changeTypePricing);
            //print_r($request->ChangeDescriptionPricing);
            $pricingChangeLogCount =  count($request->changeTypePricing);
            $pricingChangeLogCount = $pricingChangeLogCount - 1;
            for($plog=0; $plog <= $pricingChangeLogCount; $plog++){
                if($request->changeTypePricing[$plog] != 0 ){
                    $changeTypePricing = $request->changeTypePricing[$plog];
                    $ChangeDescriptionPricing =  $request->ChangeDescriptionPricing[$plog];
                    $sqlChange = $conn->prepare("INSERT INTO ".$productsChangesTable." (Code, ChangeType, Description) VALUES(?, ?, ?)"); 
                    $insertChange = $sqlChange->execute(array($Code, $changeTypePricing, $ChangeDescriptionPricing)); 
                }
            }

            $pricingChangeLogCountAdditional =  count($request->changeTypePricingAdditional);
            $pricingChangeLogCountAdditional = $pricingChangeLogCountAdditional - 1;
            for($ploga=0; $ploga <= $pricingChangeLogCountAdditional; $ploga++){
                if($request->changeTypePricingAdditional[$ploga] != 0 ){
                    $changeTypePricingAdditional = $request->changeTypePricingAdditional[$ploga];
                    $ChangeDescriptionPricingAdditional =  $request->ChangeDescriptionPricingAdditional[$ploga];
                    $sqlChange = $conn->prepare("INSERT INTO ".$productsChangesTable." (Code, ChangeType, Description) VALUES(?, ?, ?)"); 
                    $insertChange = $sqlChange->execute(array($Code, $changeTypePricingAdditional, $ChangeDescriptionPricingAdditional)); 
                }
            }
           
            
            //CHange Log
            if($request->disableChange == 1){ 
                //$sqlChange = $conn->prepare("INSERT INTO ".$productsChangesTable." (Code, ChangeType, Description) VALUES(?, ?, ?)"); 
               // $insertChange = $sqlChange->execute(array($Code, $changeType, $ChangeDescription));   
                 
            }
            
            //New Change log
            if($changeLogNewUpdate = $request->changeLogUpdate){
                foreach($changeLogNewUpdate as $rowC){
                    if($rowC->changeLogType){
                        $sqlChange = $conn->prepare("INSERT INTO ".$productsChangesTable." (Code, ChangeType, Description) VALUES(?, ?, ?)"); 
                        $insertChange = $sqlChange->execute(array($Code, $rowC->changeLogType, $rowC->changeLogDescription));   
                    }
                }

            }
            
             /***** PRICING NEW ADDITIONAL COST **********/
           // print_r($request->UpgradeFilteredPricing);

           //print_r($request->UpgradeFilteredAdditionalList);

           if($request->UpgradeFilteredAdditionalList){ 

 
                
                //Get the PricingType
                $pricingTypeArray = $request->UpgradePricingTypeUniqueOne;
               // print_r($pricingTypeArray);

                if(count($request->UpgradeFilteredAdditionalList) > 0){
                    
                    $countUpgradeAddsBrands = count($request->UpgradeFilteredAdditionalList);

                    for($ab1 = 0; $ab1 < $countUpgradeAddsBrands; $ab1++){
                        
                        
                        //print_r($request->UpgradeFilteredAdditionalList[$ab1]);



                        $countAddsList = count($request->UpgradeFilteredAdditionalList[$ab1]);

                        $levelThreeArray = $request->UpgradeFilteredAdditionalList[$ab1];

                        //Inside Arrays
                        for($ab2 = 0; $ab2 < $countAddsList; $ab2++){
                             //print_r($levelThreeArray[$ab2]);
                           
                            // always starts with 1 for the rowOrder
                             $orderRow = $ab2 + 1;

                             if($levelThreeArray[$ab2]->additionalOptionCategory){
                                 switch ($levelThreeArray[$ab2]->additionalOptionCategory){
                                    case "Decoration Option":  
                                        $additionalOptionCategory = "DO";
                                        break; 
                                    case "Optional Extra":  
                                        $additionalOptionCategory = "OE";
                                        break; 
                                    case "Decoration Charge on Optional Extra":  
                                        $additionalOptionCategory = "DCOE";
                                        break;  

                                    default: 
                                        $additionalOptionCategory = "DO"; 
                                        break;
                                 }
                             }

                             
                             

                            if($levelThreeArray[$ab2]->additionalCostID == 0 || $levelThreeArray[$ab2]->Status == "New"){

                                //Update Additional Text


                                
                              //Insert
 

                             
                              $insertTrackAdds = $conn->prepare("INSERT INTO ".$additionalOptions." 
                                        (ProductCode, PricingType, costDescription,  brandingMethod, brandingArea, maxPerUnit, additionalOptionCategory, orderRow, pricePerUnitItemCode, pricePerOrderCode, NZDUnitPrice, NZDOrderPrice, AUDUnitPrice, AUDOrderPrice, SGDUnitPrice, SGDOrderPrice, MYRUnitPrice, MYROrderPrice) 
                                        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");  
                                $insertTrackAddsDone = $insertTrackAdds->execute(
                                    array(
                                            $levelThreeArray[$ab2]->ProductCode,
                                            $levelThreeArray[$ab2]->PricingType,
                                            $levelThreeArray[$ab2]->costDescription, 
                                            $levelThreeArray[$ab2]->brandingMethod,
                                            $levelThreeArray[$ab2]->brandingArea,
                                            $levelThreeArray[$ab2]->maxPerUnit,
                                            $additionalOptionCategory,
                                            $orderRow,
                                            $levelThreeArray[$ab2]->pricePerUnitItemCode,
                                            $levelThreeArray[$ab2]->pricePerOrderCode, 
                                            $levelThreeArray[$ab2]->NZDUnitPrice,
                                            $levelThreeArray[$ab2]->NZDOrderPrice,
                                            $levelThreeArray[$ab2]->AUDUnitPrice,
                                            $levelThreeArray[$ab2]->AUDOrderPrice,
                                            $levelThreeArray[$ab2]->SGDUnitPrice,
                                            $levelThreeArray[$ab2]->SGDOrderPrice,
                                            $levelThreeArray[$ab2]->MYRUnitPrice,
                                            $levelThreeArray[$ab2]->MYROrderPrice                            
                                        )
                                );  

                            
                               // echo "INSERTED into ".$PricingType. " => " .$addUpdateColumns. " / ";
                                
                               $addUpdateColumns = $ab2 + 1;
                               $PricingType = $levelThreeArray[$ab2]->PricingType; 
                               $data = array(
                                   'cols' => $addUpdateColumns,
                                   'code' => $levelThreeArray[$ab2]->ProductCode,
                                   'pricingtype' => $levelThreeArray[$ab2]->PricingType,
                                   'costDescription' => $levelThreeArray[$ab2]->costDescription,
                                   'NZDUnitPrice' => $levelThreeArray[$ab2]->NZDUnitPrice,
                                   'NZDOrderPrice' => $levelThreeArray[$ab2]->NZDOrderPrice,
                                   'AUDUnitPrice' => $levelThreeArray[$ab2]->AUDUnitPrice,
                                   'AUDOrderPrice' => $levelThreeArray[$ab2]->AUDOrderPrice,
                                   'SGDUnitPrice' => $levelThreeArray[$ab2]->SGDUnitPrice,
                                   'SGDOrderPrice' => $levelThreeArray[$ab2]->SGDOrderPrice,
                                   'MYRUnitPrice' => $levelThreeArray[$ab2]->MYRUnitPrice,
                                   'MYROrderPrice' => $levelThreeArray[$ab2]->MYROrderPrice,
                                   'brandingMethod'=> $levelThreeArray[$ab2]->brandingMethod,
                                   'brandingArea'=> $levelThreeArray[$ab2]->brandingArea   
                               ); 
                                //Update Additional Cost
                                if($insertTrackAddsDone){ 
                                        updateUpgradeCMS($conn, $productsPricingTableTemp, $data); 
                                } 
 
                                

                            }else{ 

                                



                               
                                //Update  
                                
                                $sqlUpdateAddBrand = "UPDATE ".$additionalOptions." SET   
                                costDescription = '".$levelThreeArray[$ab2]->costDescription."', 
                                brandingMethod = '".$levelThreeArray[$ab2]->brandingMethod."',
                                brandingArea = '".$levelThreeArray[$ab2]->brandingArea."',
                                maxPerUnit = '".$levelThreeArray[$ab2]->maxPerUnit."',
                                additionalOptionCategory = '".$additionalOptionCategory."',
                                orderRow = '".$orderRow."',
                                pricePerUnitItemCode = '".$levelThreeArray[$ab2]->pricePerUnitItemCode."',
                                pricePerOrderCode = '".$levelThreeArray[$ab2]->pricePerOrderCode."', 
                                NZDUnitPrice = '".$levelThreeArray[$ab2]->NZDUnitPrice."',
                                NZDOrderPrice = '".$levelThreeArray[$ab2]->NZDOrderPrice."',
                                AUDUnitPrice = '".$levelThreeArray[$ab2]->AUDUnitPrice."',
                                AUDOrderPrice = '".$levelThreeArray[$ab2]->AUDOrderPrice."',
                                SGDUnitPrice = '".$levelThreeArray[$ab2]->SGDUnitPrice."',
                                SGDOrderPrice = '".$levelThreeArray[$ab2]->SGDOrderPrice."',
                                MYRUnitPrice = '".$levelThreeArray[$ab2]->MYRUnitPrice."',
                                MYROrderPrice = '".$levelThreeArray[$ab2]->MYROrderPrice."'   

                                WHERE     additionalCostID = '".$levelThreeArray[$ab2]->additionalCostID."' "; 
                                $sqlUpdateAddBrandDone = $conn->query($sqlUpdateAddBrand);    
 
                               

                                $addUpdateColumns = $ab2 + 1;
                                $data = array(
                                    'cols' => $addUpdateColumns,
                                    'code' => $levelThreeArray[$ab2]->ProductCode,
                                    'pricingtype' => $levelThreeArray[$ab2]->PricingType,
                                    'costDescription' => $levelThreeArray[$ab2]->costDescription,
                                    'NZDUnitPrice' => $levelThreeArray[$ab2]->NZDUnitPrice,
                                    'NZDOrderPrice' => $levelThreeArray[$ab2]->NZDOrderPrice,
                                    'AUDUnitPrice' => $levelThreeArray[$ab2]->AUDUnitPrice,
                                    'AUDOrderPrice' => $levelThreeArray[$ab2]->AUDOrderPrice,
                                    'SGDUnitPrice' => $levelThreeArray[$ab2]->SGDUnitPrice,
                                    'SGDOrderPrice' => $levelThreeArray[$ab2]->SGDOrderPrice,
                                    'MYRUnitPrice' => $levelThreeArray[$ab2]->MYRUnitPrice,
                                    'MYROrderPrice' => $levelThreeArray[$ab2]->MYROrderPrice,
                                    'brandingMethod'=> $levelThreeArray[$ab2]->brandingMethod,
                                    'brandingArea'=> $levelThreeArray[$ab2]->brandingArea     
                                );

                                 //Update Additional Cost
                                if($sqlUpdateAddBrandDone){   
                                    updateUpgradeCMS($conn, $productsPricingTableTemp, $data);
                                }

                               
                                
                            }
                        }


                    }


                        ////////////////////////////////////////BRANDING

                        $countUpgradeAddsBrands = count($request->UpgradeFilteredAdditionalList);

                        for($ab1a = 0; $ab1a < $countUpgradeAddsBrands; $ab1a++){ 
                            $arrsBranding[] = $request->UpgradeFilteredAdditionalList[$ab1a];
                        }

                        $newArray = array();
                        foreach($arrsBranding as $rowB){  
                            $newArray=array_merge($newArray, $rowB);
                        } 
                        $newOrder = 0;
                        foreach($newArray as $rowFilter){ 
                            if($rowFilter->brandingMethod){
                                //echo $newOrder. " / ";
                                $finalArrayBranding[] = $rowFilter;  
                            
                                $newOrder++;
                            }
                        }  

                        foreach($finalArrayBranding as $key => $value){
                            $newKey = $key + 1;  
                            $data = array(
                                'cols' => $newKey,
                                'code' => $value->ProductCode,
                                'pricingtype' => $value->PricingType,
                                'costDescription' => $value->costDescription,
                                'NZDUnitPrice' => $value->NZDUnitPrice,
                                'NZDOrderPrice' => $value->NZDOrderPrice,
                                'AUDUnitPrice' => $value->AUDUnitPrice,
                                'AUDOrderPrice' => $value->AUDOrderPrice,
                                'SGDUnitPrice' => $value->SGDUnitPrice,
                                'SGDOrderPrice' => $value->SGDOrderPrice,
                                'MYRUnitPrice' => $value->MYRUnitPrice,
                                'MYROrderPrice' => $value->MYROrderPrice,
                                'brandingMethod'=> $value->brandingMethod,
                                'brandingArea'=> $value->brandingArea   
                            ); 

                            updateUpgradeCMSBranding($conn, $pcTemp, $data) ;
                        } 

                         ////////////////////////////////////////BRANDING

                }
           }
 
          
             if($request->UpgradeFilteredPricing){

                        $Quantity1 = 0;
                        $Quantity2 = 0;
                        $Quantity3 = 0;
                        $Quantity4= 0;
                        $Quantity5 = 0;
                        $Quantity6 = 0;
                        $Price1 = "0.00";
                        $Price2 = "0.00";
                        $Price3 = "0.00";
                        $Price4 = "0.00";
                        $Price5 = "0.00";
                        $Price6 = "0.00";
                        $Quantity1n = 0;
                        $Quantity2n = 0;
                        $Quantity3n = 0;
                        $Quantity4n= 0;
                        $Quantity5n = 0;
                        $Quantity6n = 0;
                        $Price1n = "0.00";
                        $Price2n = "0.00";
                        $Price3n = "0.00";
                        $Price4n = "0.00";
                        $Price5n = "0.00";
                        $Price6n = "0.00";


                 if(count($request->UpgradeFilteredPricing) > 0){

                    
                    $countUpgrade = count($request->UpgradeFilteredPricing);

                   
                    
                    for($up = 0; $up < $countUpgrade; $up++){

                        

                        
                        $countFin = count($request->UpgradeFilteredPricing[$up]); 
                        $upgradeValues = $request->UpgradeFilteredPricing[$up];

                         
                         //Order
                        $orderSort = $request->UpgradeFilterKeys[$up] + 1;

                       
                         //get the first array
                         $PricingType= $upgradeValues[0]->PricingType;
                         $PriceOrder =  $orderSort;
                         $LessThanMOQ = $upgradeValues[0]->LessThanMOQ;
                         $PrimaryPriceDes = $upgradeValues[0]->PrimaryPriceDes;
                         $PriceType = $upgradeValues[0]->PriceType; 
                         $AdditionalText = $upgradeValues[0]->AdditionalText; 

                         
                        //If STATUS != NEW 
                      
                                 

                                if($upgradeValues[0]->Quantity1 != 0 || $upgradeValues[0]->Quantity1 != ""){
                                    $Quantity1= $upgradeValues[0]->Quantity1;
                                }
                                if($upgradeValues[0]->Quantity2 != 0 || $upgradeValues[0]->Quantity2 != ""){
                                    $Quantity2= $upgradeValues[0]->Quantity2;
                                }
                                if($upgradeValues[0]->Quantity3 != 0 || $upgradeValues[0]->Quantity3 != ""){
                                    $Quantity3= $upgradeValues[0]->Quantity3;
                                }
                                if($upgradeValues[0]->Quantity4 != 0 || $upgradeValues[0]->Quantity4 != ""){
                                    $Quantity4= $upgradeValues[0]->Quantity4;
                                }
                                if($upgradeValues[0]->Quantity5 != 0 || $upgradeValues[0]->Quantity5 != ""){
                                    $Quantity5= $upgradeValues[0]->Quantity5;
                                }
                                if($upgradeValues[0]->Quantity6 != 0 || $upgradeValues[0]->Quantity6 != ""){
                                    $Quantity6= $upgradeValues[0]->Quantity6;
                                }
                                
                                
                             //Update BOTH NZD AND AUD 
                                $sqlUpdateGeneral = "UPDATE ".$productsPricingTableTemp." SET  
                                PricingType = '".$PricingType."',
                                PriceOrder = '".$PriceOrder."', 
                                LessThanMOQ = '".$LessThanMOQ."',
                                PriceType = '".$PriceType."',
                                PrimaryPriceDes = '".$PrimaryPriceDes."',
                                AdditionalText = '".$AdditionalText."'   
                                WHERE    Coode = '".$Code."' AND  PricingType = '".$PricingType."' "; 
                                $sqlUpdateGeneralDone = $conn->query($sqlUpdateGeneral);    



                                // print_r($upgradeValues);
                                for($up2 = 0; $up2 < $countFin; $up2++){

                                    if($upgradeValues[$up2]->Status != "New" ){ 

                                        if($upgradeValues[$up2]->Price1 != "0.00" || $upgradeValues[$up2]->Price1 != "" || $upgradeValues[$up2]->Price1 != 0){
                                            if($upgradeValues[$up2]->Price1 == 0){
                                                $upgradeValues[$up2]->Price1 = 0.00;
                                            }
                                            $Price1 = $upgradeValues[$up2]->Price1;
                                        }
                                        if($upgradeValues[$up2]->Price2 != "0.00" || $upgradeValues[$up2]->Price2 != "" || $upgradeValues[$up2]->Price2 != 0){
                                            if($upgradeValues[$up2]->Price2 == 0){
                                                $upgradeValues[$up2]->Price2 = 0.00;
                                            }
                                            $Price2 = $upgradeValues[$up2]->Price2;
                                        }
                                        if($upgradeValues[$up2]->Price3 != "0.00" || $upgradeValues[$up2]->Price3 != "" || $upgradeValues[$up2]->Price3 != 0){
                                            if($upgradeValues[$up2]->Price3 == 0){
                                                $upgradeValues[$up2]->Price3 = 0.00;
                                            }
                                            $Price3 = $upgradeValues[$up2]->Price3;
                                        }
                                        if($upgradeValues[$up2]->Price4 != "0.00" || $upgradeValues[$up2]->Price4 != "" || $upgradeValues[$up2]->Price4 != 0){
                                            if($upgradeValues[$up2]->Price4 == 0){
                                                $upgradeValues[$up2]->Price4 = 0.00;
                                            }
                                            $Price4 = $upgradeValues[$up2]->Price4;
                                        }
                                        if($upgradeValues[$up2]->Price5 != "0.00" || $upgradeValues[$up2]->Price5 != "" || $upgradeValues[$up2]->Price5 != 0){
                                            if($upgradeValues[$up2]->Price5 == 0){
                                                $upgradeValues[$up2]->Price5 = 0.00;
                                            }
                                            $Price5 = $upgradeValues[$up2]->Price5;
                                        }
                                        if($upgradeValues[$up2]->Price6 != "0.00" || $upgradeValues[$up2]->Price6 != "" || $upgradeValues[$up2]->Price6 != 0){
                                            if($upgradeValues[$up2]->Price6 == 0){
                                                $upgradeValues[$up2]->Price6 = 0.00;
                                            }
                                            $Price6 = $upgradeValues[$up2]->Price6;
                                        }
 
                                    

                                          //Update BOTH NZD AND AUD 
                                            $sqlUpdateBoth = "UPDATE ".$productsPricingTableTemp." SET  
                                            Quantity1 = '".$Quantity1."',
                                            Quantity2 = '".$Quantity2."',
                                            Quantity3 = '".$Quantity3."',
                                            Quantity4 = '".$Quantity4."',
                                            Quantity5 = '".$Quantity5."',
                                            Quantity6 = '".$Quantity6."',
                                            Price1 = '".$Price1."',
                                            Price2 = '".$Price2."',
                                            Price3 = '".$Price3."',
                                            Price4 = '".$Price4."',
                                            Price5 = '".$Price5."',
                                            Price6 = '".$Price6."'
                                            WHERE    Coode = '".$Code."' AND ".$productsPricingTableTemp.".index =  ".$upgradeValues[$up2]->index." "; 
                                            $sqlUpdateBothDone = $conn->query($sqlUpdateBoth);   

                                        // echo $upgradeValues[$up2]->index;  
                                    }//END IF Status != NEW
                                }




                                //INSERT HERE   
                                
                                for($up3 = 0; $up3 < $countFin; $up3++){ 
 
                                        
                                       
                                        if( ($upgradeValues[$up3]->Status == "New" && $upgradeValues[$up3]->index == 0) && ($upgradeValues[0]->Quantity1 != 0 || $upgradeValues[0]->Quantity1 != "") &&  ($upgradeValues[$up3]->Price1 != "0.00" || $upgradeValues[$up3]->Price1 != "" || $upgradeValues[$up3]->Price1 != 0) ){  //If status == new

                                            if($upgradeValues[0]->Quantity1 != 0 || $upgradeValues[0]->Quantity1 != ""){
                                                $Quantity1n= $upgradeValues[0]->Quantity1;
                                            }
                                            if($upgradeValues[0]->Quantity2 != 0 || $upgradeValues[0]->Quantity2 != ""){
                                                $Quantity2n= $upgradeValues[0]->Quantity2;
                                            }
                                            if($upgradeValues[0]->Quantity3 != 0 || $upgradeValues[0]->Quantity3 != ""){
                                                $Quantity3n= $upgradeValues[0]->Quantity3;
                                            }
                                            if($upgradeValues[0]->Quantity4 != 0 || $upgradeValues[0]->Quantity4 != ""){
                                                $Quantity4n= $upgradeValues[0]->Quantity4;
                                            }
                                            if($upgradeValues[0]->Quantity5 != 0 || $upgradeValues[0]->Quantity5 != ""){
                                                $Quantity5n= $upgradeValues[0]->Quantity5;
                                            }
                                            if($upgradeValues[0]->Quantity6 != 0 || $upgradeValues[0]->Quantity6 != ""){
                                                $Quantity6n= $upgradeValues[0]->Quantity6;
                                            }
                                            
                                             
            
                                                    if($upgradeValues[$up3]->Price1 != "0.00" || $upgradeValues[$up3]->Price1 != "" || $upgradeValues[$up3]->Price1 != 0){
                                                        if($upgradeValues[$up3]->Price1 == 0){
                                                            $upgradeValues[$up3]->Price1 = 0.00;
                                                        }
                                                        $Price1n = $upgradeValues[$up3]->Price1;
                                                    }
                                                    if($upgradeValues[$up3]->Price2 != "0.00" || $upgradeValues[$up3]->Price2 != "" || $upgradeValues[$up3]->Price2 != 0){
                                                        if($upgradeValues[$up3]->Price2 == 0){
                                                            $upgradeValues[$up3]->Price2 = 0.00;
                                                        }
                                                        $Price2n = $upgradeValues[$up3]->Price2;
                                                    }
                                                    if($upgradeValues[$up3]->Price3 != "0.00" || $upgradeValues[$up3]->Price3 != "" || $upgradeValues[$up3]->Price3 != 0){
                                                        if($upgradeValues[$up3]->Price3 == 0){
                                                            $upgradeValues[$up3]->Price3 = 0.00;
                                                        }
                                                        $Price3n = $upgradeValues[$up3]->Price3;
                                                    }
                                                    if($upgradeValues[$up3]->Price4 != "0.00" || $upgradeValues[$up3]->Price4 != "" || $upgradeValues[$up3]->Price4 != 0){
                                                        if($upgradeValues[$up3]->Price4 == 0){
                                                            $upgradeValues[$up3]->Price4 = 0.00;
                                                        }
                                                        $Price4n = $upgradeValues[$up3]->Price4;
                                                    }
                                                    if($upgradeValues[$up3]->Price5 != "0.00" || $upgradeValues[$up3]->Price5 != "" || $upgradeValues[$up3]->Price5 != 0){
                                                        if($upgradeValues[$up3]->Price5 == 0){
                                                            $upgradeValues[$up3]->Price5 = 0.00;
                                                        }
                                                        $Price5n = $upgradeValues[$up3]->Price5;
                                                    }
                                                    if($upgradeValues[$up3]->Price6 != "0.00" || $upgradeValues[$up3]->Price6 != "" || $upgradeValues[$up3]->Price6 != 0){
                                                        if($upgradeValues[$up3]->Price6 == 0){
                                                            $upgradeValues[$up3]->Price6 = 0.00;
                                                        }
                                                        $Price6n = $upgradeValues[$up3]->Price6;
                                                    } 
        
                                                    
                                                   // echo $upgradeValues[$up3]->Price1. " / " .$upgradeValues[$up3]->Price2. " / ".$upgradeValues[$up3]->Price3. " / ".$upgradeValues[$up3]->Price4. " / ".$upgradeValues[$up3]->Price5. " / ".$upgradeValues[$up3]->Price6. " ====== ";

                                                   // print_r($upgradeValues[$up3]);

                                                   // echo " ====== ".$upgradeValues[$up3]->Currency. " ====== ";
                                                           
                                                            $code =  $upgradeValues[$up3]->Coode;
                                                            $naame =   $upgradeValues[$up3]->Naame;
                                                            $currency = $upgradeValues[$up3]->Currency;
                                                            $PricingType = $upgradeValues[$up3]->PricingType;
                                                            $PriceOrder = $PriceOrder;
                                                            $LessThanMOQ = $upgradeValues[$up3]->LessThanMOQ;
                                                            $PriceType = $upgradeValues[$up3]->PriceType;
                                                            $PrimaryPriceDes = $upgradeValues[$up3]->PrimaryPriceDes;
                                                            $Converted = 1;
                
                                                       
                                                    //INSERT  NEW
                                                        $insertTrack = $conn->prepare("INSERT INTO ".$productsPricingTableTemp." 
                                                            (Coode, Naame, Currency, PricingType, PriceOrder, LessThanMOQ, PriceType, PrimaryPriceDes, Quantity1, Quantity2, Quantity3, Quantity4, Quantity5, Quantity6, Price1, Price2, Price3, Price4, Price5, Price6, Converted  ) 
                                                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )"); 
                                                            $insertTrackDone = $insertTrack->execute(
                                                                array(
                                                                    $code,
                                                                    $naame,
                                                                    $currency,
                                                                    $PricingType,
                                                                    $PriceOrder, 
                                                                    $LessThanMOQ,
                                                                    $PriceType,
                                                                    $PrimaryPriceDes,
                                                                    $Quantity1n,
                                                                    $Quantity2n,
                                                                    $Quantity3n,
                                                                    $Quantity4n,
                                                                    $Quantity5n,
                                                                    $Quantity6n,
                                                                    $upgradeValues[$up3]->Price1,
                                                                    $upgradeValues[$up3]->Price2,
                                                                    $upgradeValues[$up3]->Price3,
                                                                    $upgradeValues[$up3]->Price4,
                                                                    $upgradeValues[$up3]->Price5,
                                                                    $upgradeValues[$up3]->Price6,
                                                                    $Converted
                                                                    )
                                                            );  

                                                        //Insert new AdditionalOptions     $additionalOptions
                                                       /* $insertAO = $conn->prepare("INSERT INTO ".$additionalOptions." 
                                                            (ProductCode, PricingType, orderRow ) 
                                                            VALUES(?, ?, ? )"); 
                                                            $insertAODone = $insertAO->execute(
                                                                array(
                                                                        $code, 
                                                                        $PricingType,
                                                                        1  
                                                                    )
                                                            );  */
                                                            
                                                            
                                               // }  //Save if $Price1 Exist
                                        } //If status == new
                                } // For loop 
  

                         

                    } 
                 } 
             }  
             
         


              /***** PRICING NEW ADDITIONAL COST **********/
            
            if($update){
                $command = " DELETE FROM ".$pageTrackerTable." WHERE userID=:userID";
                $stmt = $conn ->prepare($command);
                $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                $done = $stmt->execute();
                
                $data["message"] = " Product Successfully Updated ";   
            }   
            
        } 
        
        //Output
        echo json_encode($data); 
         
    }


    if($request->option == 4){
        $dataTrack = array();
        $itemCode= $request->itemCode;
        $userID = $request->userID;
        $pageTrack = $request->pageTrack;
        
        $stmt = $conn->prepare('SELECT * FROM '.$pageTrackerTable.' WHERE  codeTrack=? AND pageTrack=? ');
        $stmt->bindParam(1, $itemCode, PDO::PARAM_INT); 
        $stmt->bindParam(2, $pageTrack, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        if($row > 0)
        {
            
            if($row['userID'] == $userID){ 
                $updateTrack="UPDATE ".$pageTrackerTable."  SET codeTrack='".$itemCode."', pageTrack='".$pageTrack."', timeTrack= NOW()  WHERE userID=".$userID;
                if ($conn->query($updateTrack) == TRUE) {
                    $dataTrack["exists"] = 1; 
                }  
            }else{
                $dataTrack["exists"] = 2; 
                //checkUSerCMS 
                $checkUserCMS = $conn->prepare("SELECT * FROM ".$pageTrackerTable." WHERE userID != :userids AND codeTrack = :codes "); 
                $checkUserCMS->execute(array('codes' => $itemCode, 'userids' => $userID));
                $resultUserCMS = $checkUserCMS->fetch(); 
                //echo $results['Code']. " / " .$checkUserID;
                if($resultUserCMS){ 
                    $resUserCMS = $conn->prepare("SELECT * FROM ".$userData." WHERE userID = :useridCheck  "); 
                    $resUserCMS->execute(array('useridCheck' => $resultUserCMS['userID']));
                    $resultCheckEmailUser = $resUserCMS->fetch(); 
                    $dataTrack["resultCheckEmailUser"] = $resultCheckEmailUser['userEmail'];   
                } 
            }
            
        }else{
            $stmt1 = $conn->prepare('SELECT * FROM '.$pageTrackerTable.' WHERE  userID=?  ');
            $stmt1->bindParam(1, $userID, PDO::PARAM_INT);
            $stmt1->execute();
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC); 
            if($row1 > 0){ 

                $updateTrack="UPDATE ".$pageTrackerTable."  SET codeTrack='".$itemCode."', pageTrack='".$pageTrack."', timeTrack= NOW()  WHERE userID=".$userID;
                if ($conn->query($updateTrack) == TRUE) {
                    $dataTrack["exists"] = 3; 
                }  

            }else{
                $insertTrack = $conn->prepare("INSERT INTO ".$pageTrackerTable." (userID, codeTrack, pageTrack) VALUES(?, ?, ?)"); 
                $insertTrackDone = $insertTrack->execute(array($userID, $itemCode, $pageTrack));   
                $dataTrack["exists"] = 4;
            } 
        } 

        /* 
        $stmt1 = $conn->prepare('SELECT * FROM '.$pageTrackerTable.' WHERE  userID=?  ');
        $stmt1->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC); 
        if($row1 > 0){ 
            $updateTrack="UPDATE ".$pageTrackerTable."  SET codeTrack='".$itemCode."', pageTrack='".$pageTrack."'  WHERE userID=".$userID;
            if ($conn->query($updateTrack) == TRUE) {
                $dataTrack["exists"] = 1;
                
            }   
        }else{  
            $insertTrack = $conn->prepare("INSERT INTO ".$pageTrackerTable." (userID, codeTrack, pageTrack) VALUES(?, ?, ?)"); 
            $insertTrackDone = $insertTrack->execute(array($userID, $itemCode, $pageTrack));   
            $dataTrack["exists"] = 0;
        }
        */

        echo json_encode($dataTrack);  
    }

    //Dicard changes and delete
    if($request->option == 5){
        $userID = $request->userID; 
        $command = " DELETE FROM ".$pageTrackerTable." WHERE userID=:userID";
        $stmt = $conn ->prepare($command);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $done = $stmt->execute();
        return $done; 
    }

    if($request->option == 6){
       $name = $request->name;
       $code = $request->code;
       $currencyPrice = $request->currencyPrice;
       $pricingPrice = $request->pricingPrice;
       $totalAdds = $request->totalAdds;
       $insertPricing = $conn->prepare("INSERT INTO ".$productsPricing." (Coode, Naame, Currency, PricingType, PriceOrder) VALUES(?, ?, ?, ?, ?)"); 
       $insertPricingDone = $insertPricing->execute(array($code, $name, $currencyPrice, $pricingPrice, $totalAdds));  
       
       echo "PriceAdded";

    }

    if($request->option == 7){
        

        $reqPrice = $conn->prepare("SELECT * FROM ".$productsPricing." WHERE Coode = '".$request->id."' ORDER BY PriceOrder ASC "); 
        $reqPrice->execute();
        $resultEachPricing = $reqPrice->fetchAll();
 
        $resultCount= count($resultEachPricing); 
        for($aa = 0; $aa <= $resultCount; $aa++){ 
            //print_r($resultEachPricing[$aa]); 
            for($a1 = 1; $a1 <= 12; $a1++){
                if($resultEachPricing[$aa]['AdditionalCostDesc'.$a1] != null){
                    $Add1[] = array( $resultEachPricing[$aa]['index'] => array( $resultEachPricing[$aa]['AdditionalCostDesc'.$a1], $resultEachPricing[$aa]['AdditionalCost'.$a1], $resultEachPricing[$aa]['SetupCharge'.$a1]));
                     
                } 
            }  
        } 
         $Add1Count = count($Add1);
         $Add1Count =  $Add1Count - 1;
        for($f = 0; $f<= $Add1Count; $f++){
            $add1Fin[] = $Add1[$f];
        }
        //print_r( $Add1); 
         echo json_encode($add1Fin);  

    }



    if($request->option == 8){
       // $reqPrice = $conn->prepare("SELECT * FROM ".$productsPricing." WHERE  ".$productsPricing.".index= '".$request->id."'  "); 
        $reqPrice = $conn->prepare("SELECT * FROM ".$productsPricing." WHERE Coode = '".$request->id."' ORDER BY PriceOrder ASC "); 
        $reqPrice->execute();
        $resultEachPricing = $reqPrice->fetchAll();
        $resultCount= count($resultEachPricing); 
        
        foreach($resultEachPricing as $key => $value){
            //print_r($resultEachPricing[$key]);
            for($c = 1; $c <= 12; $c++){
                if($resultEachPricing[$key]['AdditionalCostDesc'.$c] != null || $resultEachPricing[$key]['AdditionalCostDesc'.$c] !=  ""){
                     $desc[] = $resultEachPricing[$key]['index'];
                     //$desc[] = $c - 1;
                     $desc2[] =  $c;
                }
                //echo $resultEachPricing[$key]['AdditionalCostDesc'.$c];
            }
            
            //$cFirst[] = array($resultEachPricing[$key]['index']);
        }
        
        //print_r($desc);
        //print_r($desc2);
         
        $arrayComb = array_combine ($desc, $desc2);

        $result = array_unique($desc);
         
        echo json_encode($arrayComb);  
    }

    //Delete pricing
    if($request->option == 9){
        $command = " DELETE FROM ".$productsPricing." WHERE ".$productsPricing.".index=:id";
        $stmt = $conn ->prepare($command);
        $stmt->bindParam(':id', $request->id, PDO::PARAM_INT);
        $done = $stmt->execute();

        if($done){
           // echo $request->id + " - Pricing Deleted!";
        }
    }

    if($request->option == 10){
        //PMS
        
        $reqPmsCode = $conn->prepare("SELECT Code, PartName, ComponentCode, SortCode, PmsCode FROM ".$productsStock." WHERE ".$productsStock.".Code = '".$request->code."' && SortCode != '0'  ORDER BY SortCode ASC "); 
        $reqPmsCode->execute(); 
        $resultsStock = $reqPmsCode->fetchAll();  

        $json_data=array();
        for($i = 0; $i < count($resultsStock); $i++ ){
            $json_arrayS['Code']=$resultsStock[$i]['Code'];    
            $json_arrayS['PartName']=   utf8_encode($resultsStock[$i]['PartName']);    // Edit this or Filter      
            $json_arrayS['ComponentCode']=$resultsStock[$i]['ComponentCode'];  
            $json_arrayS['SortCode']=$resultsStock[$i]['SortCode'];       
            $json_arrayS['PmsCode']=$resultsStock[$i]['PmsCode'];   
            
            array_push($json_data, $json_arrayS);
        } 


        //print_r($resultPms);
        echo json_encode($json_data);  
    }



    
    
    if($_POST['option'] == 11){
        
        $cropImage = new \claviska\SimpleImage();
        $cropImageSmall = new \claviska\SimpleImage(); 

         $imageCode = $_POST['editImageCode'];
         $replaceNumber = $_POST['formCondition']; 
         $updateCount =  $_POST['editImageCountNew'];
         $imagePrim =  $_POST['editImagePrim'];
        
       
        if($replaceNumber == 'main'){
            if(!empty($_FILES))  
            {  
                
               /* if($_FILES['addfiles']['type'] == 'image/jpeg'){ 
                    //print_r($_FILES);
                    $fileName =  $imageCode.'-'.$_POST['editImageCountNew'].'.jpg';
         
                    $path1 = $pathUrl1 . $fileName; 
                    $path2 = $pathUrl2 . $fileName; 

                    $uploaded1 = uploadImage($_FILES['addfiles']['tmp_name'], $path1, $path2);
                    //$uploaded2 = uploadImage($_FILES['addfiles']['tmp_name'], $path2);
                    //Update Count
                    $sql = "UPDATE ".$pc." SET   ImageCount= '".$updateCount."' WHERE Prim='".$imagePrim."'";
                    $imageUploadGood = $conn->query($sql);  

                    //Resize to 1500px
                    $cropImage->fromFile($pathUrl1.$fileName);
                    $cropImage->resize(1500,1500);
                    $cropImage->toFile($pathUrl1.$fileName);  

                    //Resize to thumbnails 65px
                    $cropImageSmall->fromFile($pathUrl2.$fileName);
                    $cropImageSmall->resize(65,65);
                    $cropImageSmall->toFile($pathUrl2.$fileName);  

                    echo $uploaded1;    
                    //echo $uploaded2;  
                }else{
                    echo "0";
                } */

                if($_FILES['addfiles']['type'] == 'image/jpeg'){ 
                    //print_r($_FILES);
                    $fileName =  $imageCode.'-'.$_POST['editImageCountNew'].'.jpg';
                    $fileNamePrimary =  $imageCode.'.jpg';
         
                    $path1 = $pathUrl1 . $fileName; 
                    $path2 = $pathUrl2 . $fileName; 
                    
                    if($updateCount == 0){ 
                        $path3 = $pathUrl2 . $fileNamePrimary; 
                    }
                     

                    $uploaded1 = uploadImage($_FILES['addfiles']['tmp_name'], $path1, $path2, $path3);
                    //$uploaded2 = uploadImage($_FILES['addfiles']['tmp_name'], $path2);
                    //Update Count
                    $sql = "UPDATE ".$pc." SET   ImageCount= '".$updateCount."' WHERE Prim='".$imagePrim."'";
                    $imageUploadGood = $conn->query($sql);  

                    //Resize to 1500px
                    $cropImage->fromFile($pathUrl1.$fileName);
                    $cropImage->resize(1500,1500);
                    $cropImage->toFile($pathUrl1.$fileName);  

                    //Resize to thumbnails 65px
                    $cropImageSmall->fromFile($pathUrl2.$fileName);
                    $cropImageSmall->resize(65,65);
                    $cropImageSmall->toFile($pathUrl2.$fileName);  

                    if($updateCount == 0){ 
                        $cropImageSmall->fromFile($pathUrl2.$fileNamePrimary);
                        $cropImageSmall->resize(282,282);
                        $cropImageSmall->toFile($pathUrl2.$fileNamePrimary); 
                    }

                    echo $uploaded1;     
                    //echo $uploaded2;  
                }else{
                    echo "0";
                } 


            }  

                
            

        }else{

            if(!empty($_FILES))  
            {  
                /*if($_FILES['addfiles']['type'] == 'image/jpeg'){ 

                    $fileName =  $imageCode.'-'.$replaceNumber.'.jpg';
                   // echo $fileName;
                    $path1 = $pathUrl1 . $fileName; 
                    $path2 = $pathUrl2 . $fileName; 
                    $uploaded2 = uploadImage($_FILES['addfiles']['tmp_name'], $path1, $path2);
                    
                    //Resize to 1500px
                    $cropImage->fromFile($pathUrl1.$fileName);
                    $cropImage->resize(1500,1500);
                    $cropImage->toFile($pathUrl1.$fileName);  

                    //Resize to thumbnails 65px
                    $cropImageSmall->fromFile($pathUrl2.$fileName);
                    $cropImageSmall->resize(65,65);
                    $cropImageSmall->toFile($pathUrl2.$fileName); 

                    echo $uploaded2;    

                }else{
                    echo "0";
                }  */
                if($_FILES['addfiles']['type'] == 'image/jpeg'){ 

                    $fileName =  $imageCode.'-'.$replaceNumber.'.jpg';
                    $fileNamePrimary =  $imageCode.'.jpg';
                   // echo $fileName;
                    $path1 = $pathUrl1 . $fileName; 
                    $path2 = $pathUrl2 . $fileName; 

                    if($replaceNumber == 0){ 
                        $path3 = $pathUrl2 . $fileNamePrimary; 
                    }

                    $uploaded2 = uploadImage($_FILES['addfiles']['tmp_name'], $path1, $path2, $path3);
                    
                    //Resize to 1500px
                    $cropImage->fromFile($pathUrl1.$fileName);
                    $cropImage->resize(1500,1500);
                    $cropImage->toFile($pathUrl1.$fileName);  

                    //Resize to thumbnails 65px
                    $cropImageSmall->fromFile($pathUrl2.$fileName);
                    $cropImageSmall->resize(65,65);
                    $cropImageSmall->toFile($pathUrl2.$fileName); 

                    
                    if($replaceNumber == 0){ 
                        $cropImageSmall->fromFile($pathUrl2.$fileNamePrimary);
                        $cropImageSmall->resize(282,282);
                        $cropImageSmall->toFile($pathUrl2.$fileNamePrimary); 
                    }

                    echo $uploaded2;    

                }else{
                    echo "0";
                }  

            }
               
            
        }   
        
    }



   //Remove or delete Image
   if($request->option == 12){

        $Prim = $request->Prim;
        $Code = $request->Code;
        $Image = $request->Image;

        $imageFile = $Code.'-'.$Image.'.jpg';

        unlink($pathUrl1.$imageFile);
        unlink($pathUrl2.$imageFile);
        
        $sql = "UPDATE ".$pc." SET   ImageCount= '".($Image-1)."' WHERE Prim='".$Prim."'";
        $imageUploadGood = $conn->query($sql);  

        if($imageUploadGood){
            $command = " DELETE FROM ".$segmentStockCode." WHERE  FGCode= '".$Code."' AND Image = '".$Image."' ";
            $stmt = $conn ->prepare($command); 
            $done = $stmt->execute(); 
        } 
        echo "success";

    }

    //Colours
    if($request->option == 13){ 
         
        $colour= $request->colour;
        $imgNum= $request->imgNum;
        $code= $request->code;

        if($colour == null){
            $colour = 0;
        }

        $results = saveUpdate($colour, $imgNum, $code, 2, $conn, $segmentStockCode);
        if($results){
            echo $results;
        } 
    }

    //Stock
    if($request->option == 14){ 
         
        $stock= $request->stock;
        $imgNum= $request->imgNum;
        $code= $request->code;

        if($stock == 0 || $stock == null){
            $stock = 0;
        }
        $results = saveUpdate($stock, $imgNum, $code, 1, $conn, $segmentStockCode);
        if($results){
            echo $results;
        } 
    }

    //Check if the code exists
    if($request->option == 15){
        $codecheck = $request->codecheck;
        $req = $conn->prepare("SELECT * FROM ".$pc." WHERE Code =  :id "); 
        $req->execute(array('id' => $codecheck));
        $results = $req->fetch();

        if($results){
            echo 1;
        }else{
            echo 0;
        }
    }

    //Add new product
    if($request->option == 16){
        $codeProduct = $request->codeProduct;
        $nameProduct = $request->nameProduct;
        $NewPricingType = $request->NewPricingType;
        
        $sqlNewPricing = $conn->prepare("INSERT INTO ".$productsPricingTableTemp." (Coode, Naame, Currency, PricingType, PriceOrder, Converted) VALUES(?, ?, ?, ?, ?, ?)"); 
        $insertNewPricing = $sqlNewPricing->execute(array($codeProduct, $nameProduct, 'NZD', $NewPricingType, 1, 1)); 


        $sqlNew = $conn->prepare("INSERT INTO ".$pcTemp." (Code, Name) VALUES(?, ?)"); 
        $insertNew = $sqlNew->execute(array($codeProduct, $nameProduct)); 

        if($insertNew){
             echo $conn->lastInsertId();
        } 


    }

    if($request->option == 17){
        $overwriteCode = $request->overwriteCode;
        $overwritePrim = $request->overwritePrim;
        //echo $overwriteCode. "/" .$overwritePrim;
        $command = " DELETE FROM ".$pageTrackerTable." WHERE codeTrack= '".$overwriteCode."' ";
        $stmt = $conn ->prepare($command); 
        $done = $stmt->execute(); 
        
        if($done){
             echo $overwritePrim;
        }
 
     }

     if($request->option == 18){
        $imgNum = $request->imgNum;
        $caption = $request->caption;
        $code = $request->code;

        $req = $conn->prepare("SELECT *  FROM ".$segmentStockCode." WHERE FGCode = '".$code."' AND Image = '".$imgNum."'    "); 
        $req->execute();
        $results = $req->fetch(PDO::FETCH_ASSOC);

        if($results > 0){ 

            $sql = "UPDATE ".$segmentStockCode."  SET Caption='".$caption."' WHERE FGCode='".$code."' AND Image= '".$imgNum."' "; 
            if ($conn->query($sql) == TRUE) {
                $captionResults = 1;
            }

        }else{

            $sql = $conn->prepare("INSERT INTO ".$segmentStockCode." (FGCode, Image, Caption) VALUES (?, ?, ?)"); 
            $captionResults = $sql->execute(array($code, $imgNum, $caption));  

        }

        return $captionResults;   
        
     }


     /********* UPGRADE CMS *****/
       //Delete pricing Currency
    if($request->option == 19){
        $prim = $request->prim;
        $ind = $request->ind;
        $code = $request->code;
        $currency = $request->currency;
      
        $command = " DELETE FROM ".$productsPricingTableTemp." WHERE ".$productsPricingTableTemp.".index=:ind AND Coode=:code AND Currency=:currency";
        $stmt = $conn ->prepare($command);
        $stmt->bindParam(':ind', $ind, PDO::PARAM_INT);
        $stmt->bindParam(':code', $code, PDO::PARAM_INT);
        $stmt->bindParam(':currency', $currency, PDO::PARAM_INT);
        $done = $stmt->execute();  

        echo "done";
    }

    if($request->option == 20){ 
        $code = $request->code;
        $pricingtype = $request->pricingtype;
      
        $command = " DELETE FROM ".$productsPricingTableTemp." WHERE  Coode=:code  AND PricingType=:pricingtype";
        $stmt = $conn ->prepare($command); 
        $stmt->bindParam(':code', $code, PDO::PARAM_INT);
        $stmt->bindParam(':pricingtype', $pricingtype, PDO::PARAM_INT);
        $done = $stmt->execute();   

        echo "done";
    }

    if($request->option == 21){ 
         $name = $request->name;
         $code = $request->code;
         $pricingtype = $request->pricingtype;

        //print_r($request->editForms->UpgradeFilteredPricing);

                    $arraysUpgradeOutput = $request->editForms;
                    $arraysUpgrade = $request->editForms->UpgradeFilteredPricing;

                    $countThis =  count($arraysUpgrade);
                    

                    $arrayCompareCurrency = array(0=>'NZD', 1=>'AUD', 2=>'SGD', 3=>'MYR' );

             
                    
                     //Get Currencies and Filtered ********************************************/
                     $addCount = 0;
                     foreach($arraysUpgrade as $key => $value){

                            //This will add new form
                            $arraysUpgrade[$countThis] = array();
                         
                            $xc = 0;
                            foreach($arraysUpgrade[$key] as $newRow){
                                $getCurrency[$xc] = $newRow->Currency;
                                $xc++; 
                            }   
                            $resultCurrencyFiltered =array_diff($arrayCompareCurrency, $getCurrency);
                            //print_r($resultCurrencyFiltered);
    
                            
                            $countPr = count($arraysUpgrade[$key]);

                            //Use forloop tomorrow
                            for($cr = 0; $cr < 4; $cr++){
    
                                    $countPrFinal =  $cr;
                                    //echo $currs. " => " .$countPrFinal;
                                    $arraysUpgrade[$countThis][$countPrFinal] = array(
                                        "index" => 0,
                                        "Coode"=> $code,   
                                        "Currency"=> $arrayCompareCurrency[$cr],  
                                        "Converted"=> 1, 
                                        "LessThanMOQ" => "N", 
                                        "Naame"=> $name, 
                                        "PricingType"=> $pricingtype, 
                                        "PrimaryPriceDes" => "Unbranded",
                                        "PriceType" => "U",
                                        "Quantity1" => 0,
                                        "Quantity2" => 0,
                                        "Quantity3" => 0,
                                        "Quantity4" => 0,
                                        "Quantity5" => 0,
                                        "Quantity6" => 0,
                                        "Price1" => 0.00,
                                        "Price2" => 0.00,
                                        "Price3" => 0.00,
                                        "Price4" => 0.00,
                                        "Price5" => 0.00,
                                        "Price6" => 0.00,
                                        "Status" => "New"

                                    );
     
                            }   
                            
                            $upgradeKeys[] = $addCount;

                            $addCount++; 
                     }
                     $lastIn = count($upgradeKeys) + 1;
                     for($ad = 0; $ad < $lastIn; $ad++){
                        $upgradeKeysFinal[] = $ad;
                     }
                      
                     $arraysFinalUpgrade['UpgradeNewFilterPricing'] = $arraysUpgrade;
                     $arraysFinalUpgrade['UpgradeNewFilterKeys'] = $upgradeKeysFinal;
                     
                      
                    $someJSON = json_encode($arraysFinalUpgrade);
                    echo $someJSON;  

                   // print_r($arraysUpgrade);
                    //Get Currencies and Filtered ********************************************

                   
           



        /*

        if($code && $pricingtype){
            //Check if exist
            $req = $conn->prepare("SELECT Coode FROM  ".$productsPricingTableTemp." WHERE Coode = ".$code." ");  
            $req->execute();
            $results  = $req->fetchAll();

            //Get the Maximum Order Number
            $resultMax = 1;
            if(count($results) > 0){ 
                
                $reqmax = $conn->prepare("SELECT MAX(PriceOrder) as priceOrder  FROM   ".$productsPricingTableTemp." WHERE Coode = ".$code."   "); 
                $reqmax->execute();
                $resultsM = $reqmax->fetch(PDO::FETCH_ASSOC); 
                $resultMax = $resultsM['priceOrder'] + 1;
            
            } 

           // echo $resultMax;

            // $sql = $conn->prepare("INSERT INTO ".$productsPricingTableTemp." (Coode, Name, Currency, PricingType, PriceOrder) VALUES (?, ?, ?, ?, ?)"); 
            // $insertNewPricing = $sql->execute(array($code, $name, $currency, $pricingtype, $resultMax));  


            //echo "done";
        }*/
        
    }


    if($request->option == 22){ 
        $code = $request->code;
        $pricingtype = $request->pricingtype;
        $level = $request->level;


        //print_r($request->additionalBranding[$level]);
        $addBrandArray = $request->additionalBranding[$level];
        $countLoop = count($request->additionalBranding[$level]);

        
        $addBrandArray[$countLoop] = array(
                "additionalCostID" => 0,
                "ProductCode"=> $code,   
                "PricingType"=> $pricingtype,  
                "costDescription"=> "", 
                "brandingMethod" => "", 
                "brandingArea"=> "", 
                "maxPerUnit"=> "", 
                "additionalOptionCategory" => "",
                "orderRow" => $countLoop,
                "pricePerUnitItemCode" => "",
                
                "NZDUnitPrice" => 0.00,
                "NZDOrderPrice" => 0,
                "AUDUnitPrice" => 0.00,
                "AUDOrderPrice" => 0,
                "SGDUnitPrice" => 0.00,
                "SGDOrderPrice" => 0,
                "MYRUnitPrice" => 0.00,
                "MYROrderPrice" => 0,
                "Status" => "New" 
        );

        //print_r( $addBrandArray);
        
        $arraysFinalUpgradeAddsBranding = $addBrandArray;
        $someJSON = json_encode($arraysFinalUpgradeAddsBranding);
        echo $someJSON; 
         
    }

    if($request->option == 23){ 
        $id = $request->id;
         
        $command = " DELETE FROM ".$additionalOptions." WHERE  additionalCostID=:id ";
        $stmt = $conn ->prepare($command); 
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $done = $stmt->execute();   

        echo "done";
    }


    if($request->option == 24){ 
        $ind = $request->ind;
        $code = $request->code;
        $currency = $request->currency;

        if($ind  && $code && $currency){
            $req = $conn->prepare("SELECT  Price1, Price2, Price3, Price4, Price5, Price6 FROM  ".$productsPricingTableTemp." WHERE ".$productsPricingTableTemp.".index = '".$ind."' AND Coode = '".$code."' AND Currency = '".$currency."' ");  
            $req->execute();
            $results = $req->fetch(PDO::FETCH_ASSOC);

            $someJSON = json_encode($results);
            echo $someJSON; 

        }

      
      
    }



    /********** UPGRADE CMS ***/

    function updateUpgradeCMS($conn, $productsPricingTableTemp, $data){   
         
        //NZD
        $sqlNZD = "UPDATE ".$productsPricingTableTemp." SET  AdditionalCostDesc".$data['cols']."  ='".$data['costDescription']."', AdditionalCost".$data['cols']."  ='" .$data['NZDUnitPrice']."', SetupCharge".$data['cols']." = '".$data['NZDOrderPrice']."'  WHERE Coode =".$data['code']." AND PricingType = '".$data['pricingtype']."' AND Currency = 'NZD'  ";
        $updateNZD= $conn->query($sqlNZD);   

        //AUD
        $sqlAUD = "UPDATE ".$productsPricingTableTemp." SET  AdditionalCostDesc".$data['cols']."  ='".$data['costDescription']."', AdditionalCost".$data['cols']."  ='" .$data['AUDUnitPrice']."', SetupCharge".$data['cols']." = '".$data['AUDOrderPrice']."'  WHERE Coode =".$data['code']." AND PricingType = '".$data['pricingtype']."' AND Currency = 'AUD'  ";
        $updateAUD= $conn->query($sqlAUD);   

        //SGD
        $sqlSGD = "UPDATE ".$productsPricingTableTemp." SET  AdditionalCostDesc".$data['cols']."  ='".$data['costDescription']."', AdditionalCost".$data['cols']."  ='" .$data['SGDUnitPrice']."', SetupCharge".$data['cols']." = '".$data['SGDOrderPrice']."'  WHERE Coode =".$data['code']." AND PricingType = '".$data['pricingtype']."' AND Currency = 'SGD'  ";
        $updateSGD= $conn->query($sqlSGD);   

        //MYR
        $sqlMYR = "UPDATE ".$productsPricingTableTemp." SET  AdditionalCostDesc".$data['cols']."  ='".$data['costDescription']."', AdditionalCost".$data['cols']."  ='" .$data['MYRUnitPrice']."', SetupCharge".$data['cols']." = '".$data['MYROrderPrice']."'  WHERE Coode =".$data['code']." AND PricingType = '".$data['pricingtype']."' AND Currency = 'MYR'  ";
        $updateMYR= $conn->query($sqlMYR);    
 
    }


    function updateUpgradeCMSBranding($conn, $pcTemp, $data){ 
             //print_r($data);
             $sqlBranding = "UPDATE ".$pcTemp." SET  PrintType".$data['cols']."  ='" .$data['brandingMethod']. "', PrintDescription".$data['cols']."  ='" .$data['brandingArea']. "' WHERE Code =".$data['code']." ";
             $branding = $conn->query($sqlBranding);    
    }

    function saveUpdate($stock, $imgNum, $code, $data, $conn, $segmentStockCode){
        if($data == 1){
            $column = 'StockCode';
        }else{
            $column = 'Colour';
        }  
        //$res= $stock .'/' .$imgNum.'/' .$code.'/' .$data.'/' .$column;
        // return $res;
         
        
        $req = $conn->prepare("SELECT *  FROM ".$segmentStockCode." WHERE FGCode = '".$code."' AND Image = '".$imgNum."'    "); 
        $req->execute();
        $results = $req->fetch(PDO::FETCH_ASSOC);

        if($results > 0){ 
           // $statStock = 'Exists';
            $sql = "UPDATE ".$segmentStockCode."  SET ".$column."='".$stock."' WHERE FGCode='".$code."' AND Image= '".$imgNum."' "; 
            if ($conn->query($sql) == TRUE) {
                $statStock = 1;
            }

        }else{
            //$statStock = 'Non Exists';  
             $sql = $conn->prepare("INSERT INTO ".$segmentStockCode." (FGCode, Image, ".$column.") VALUES (?, ?, ?)"); 
             $statStock = $sql->execute(array($code, $imgNum, $stock));  
        } 
    
        return $statStock;   
    }


    /* 
    function uploadImage($file, $path, $path2){
                if(move_uploaded_file($file, $path))  
                {  
                    copy($path, $path2); 
                    $msg =  'File Uploaded';    
                }else{
                    $msg =  "Not uploaded";
                } 
                return $msg;  
    } */
     
    function uploadImage($file, $path, $path2, $path3){
        if(move_uploaded_file($file, $path))  
        {  
            copy($path, $path2);  
            copy($path, $path3);  
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

    function cleanValue2($Val){
        //$newVal = htmlspecialchars($Val, ENT_QUOTES); 
        $res = $Val;
 
		$specChars = array(
			'!' => '',    '"' => '',
			'$' => '',    '%' => '',
			'&amp;' => '',    '\'' => '',   '(' => '',
			')' => '',    '*' => '',    
			',' => '',    '₹' => '',    '.' => '',
			'/-' => '',    ':' => '',    ';' => '',
			'<' => '',    '=' => '',    '>' => '',
			'?' => '',    '@' => '',    '[' => '',
			'\\' => '',   ']' => '',    '^' => '',
			'_' => '',    '`' => '',    '{' => '',
			'|' => '',    '}' => '',    '~' => '',
			'-----' => '-',    '----' => '-',    '---' => '-',
			'/' => '',    '--' => '-',   '/_' => '-',  '&039'=> '',
			'&039;'=>'', 'â€”' => '', '—' => '-', '�' =>'-' 
			
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
        }
         
        return $res;
    }

    function getSizingValues($sizingVal, $sizingLine, $edit = null){ 
        if($sizingLine == "-"){
            $sizingLine = "&nbsp;";
        }
        $s1 = $sizingLine. ","; 
        $count = count((array)$sizingVal);
        if($edit != null){
            $finalCount = $count; 
        }else{
            $finalCount = $count - 1; 
        }
        
        foreach ($sizingVal as $key => $value) { 
            if($value == "-"){
                $value = "&nbsp;";
            }
            if($value != null){
                if($key == $finalCount){ 
                    $s2 .= $value;
                }else{
                    $s2 .= $value. ",";
                }  
            }
            
        }
        $sizingLine = $s1 . $s2;
        $result = substr($sizingLine, -1);
        if($result == ","){
            $sizingLine = substr($sizingLine, 0, -1); 
        }else{
            $sizingLine = $sizingLine;
        }
        return $sizingLine;
    }
 

    function cvf_convert_object_to_array($data) {

        if (is_object($data)) {
            $data = get_object_vars($data);
        }
    
        if (is_array($data)) {
            return array_map(__FUNCTION__, $data);
        }
        else {
            return $data;
        }
    }
?>