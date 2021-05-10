<?php

    $sql= getProducts($table); 
   
    $json_data=array();
    foreach($sql as $rec)//foreach loop  
    {  
      $json_array['Prim']=$rec['Prim']; 
      $json_array['Code']=$rec['Code'];  
     // $json_array['Name']=clean($rec['Name']); 
      $json_array['Name']= html_entity_decode($rec['Name'], ENT_QUOTES);
      if($rec['Active'] == 1){
          $Active = 'Active';
      }else{
         $Active = 'Inactive';
      }
      $json_array['Active'] = $Active;
      array_push($json_data,$json_array);
    } 
    $my_edit = json_encode($json_data,JSON_PRETTY_PRINT); 
     
    
    
    $currencies= getCurrencyData($table); 
 
    $json_currency=array(); 
    foreach($currencies as $rec3)//foreach loop  
    {  
    $rec3['currencyDescription'];
    $json_array3['currencyID']=$rec3['currencyID'];
    $json_array3['currencyName']= $rec3['currencyName'];  
    $json_array3['currencyDescription'] = $rec3['currencyDescription'];  
    array_push($json_currency,$json_array3);
    } 
    $currencyDatas = json_encode($json_currency,JSON_PRETTY_PRINT); 


    //JSON GET
    $serverPath = $_SERVER['DOCUMENT_ROOT']; 
    $pathUrl = $serverPath.'/TGP-Admin/json/'; 
    $jsonAdd = file_get_contents($pathUrl.'additionalOptions.json');  
    $json_additionals =   json_decode($jsonAdd,true); 

    $js1=array();
    foreach($json_additionals as $js){
    $json_arrs['jsonArrays']=$js; 
    array_push($js1,$json_arrs);
    }
    $json_additionalOptions = json_encode($js1,JSON_PRETTY_PRINT); 

    

     

    function clean($string) { 
        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
   }
?>

<script>


// Define the `phonecatApp` module 
 
//tgpApp.controller("editCtrl",function($scope, $http, $httpParamSerializerJQLike, $timeout, Upload,   $sce){

tgpApp.controller("editCtrl",  ['$scope', '$http', '$httpParamSerializerJQLike',  'Upload', '$timeout', '$sce',  function($scope, $http, $httpParamSerializerJQLike, Upload, $timeout, $sce){  

  $scope.query = {}
  $scope.filter = {};
  $scope.queryBy = '$'
  $scope.products = <?php echo $my_edit; ?>;
  $scope.orderProp="Code";  
  //Get the Data ID 
  $scope.checkUser = <?php echo $userID; ?>;
  $scope.userIsEditing = false;

  $scope.editImagesActive = false;
  $scope.currencyDatas = <?php echo $currencyDatas; ?>; 
  $scope.removeBtnPricing = false;
  $scope.hideNewForm = false;
  $scope.brandPop = false;
  $scope.queryB = {}
  $scope.filterB = {};
  $scope.queryBB = '$'
  $scope.jsonAdditionals = <?php echo $json_additionalOptions; ?>;
  $scope.urlRefresh = '<?php echo "//".$_SERVER['SERVER_NAME']; ?>' + '/refresh/all'; 
  $scope.countChangeLog = 1;
  $scope.countRowLog = 0;
  $scope.checkBoxesChangeLog = {};
 

 $scope.BrandingOptionDropdown =  [  
         "Pad Print",
         "Screen Print", 
         "Laser Engraving",
         "Rotary Digital Print",
         "Imitation Etch",
         "Resin Coated Finish",
         "Digital Transfer",
         "Colourflex Transfer",
         "Sublimation",
         "Digital Print",
         "Digital Label",
         "Direct Digital",
         "Debossing",
         "Debossed",
         "Debossing XL",
         "Thermo Debossing",
         "Thermo Debossing XL",
         "Embroidery",
         "Silicone Digital Print"
     
 ];


 $scope.searchBrandingOptions = function(up, ind){
     
    $scope.resetBranding(); 
    $scope.brandPop = true;  
     //$scope.BrandingOptionDropdownList = $scope.BrandingOptionDropdown;  

    var elementOpen = angular.element(".floatBrand" + up + ind); 
                elementOpen.css('display', 'block');  
                 
    $scope.editForms.UpgradeFilteredAdditionalList[up][ind].brandingMethod = "";
 }

 $scope.updateBranding = function(up, ind, brn){
     //console.log(up + " / " + ind + " / " + brn);
    $scope.editForms.UpgradeFilteredAdditionalList[up][ind].brandingMethod = brn;
    $scope.resetBranding(); 
 }

 $scope.resetBranding = function(){
     $scope.brandPop = false; 
     $scope.BrandingOptionDropdownList = {};
    var elementOpen = angular.element(".floatBrandingOption"); 
                elementOpen.css('display', 'none');   
 }

 $scope.collapseAll = function(){
    $scope.brandPop = false; 
    var elementOpen = angular.element(".floatBrandingOption"); 
                elementOpen.css('display', 'none');   
 }

     


    $scope.selectItem = function(id) {     

        $scope.PreviewTableResult ='';
        $scope.pricingIncrements = '';
        $scope.removeBtnPricing = false;
        $scope.hideNewForm = false;
        $scope.brandPop = false;

        $scope.clearTableBG();

       

        //Active selected products
        var element = angular.element('.active'+ id); 
        element.css('background-color', 'rgb(171, 171, 171)');  


        $http({
            method: "post",
            url:  "<?php echo $angularPost; ?>",
            data: {
                checkUserID: $scope.checkUser,
                id: id,
                option: 1,
                controlName: "<?php  echo $angularControllerFile; ?>",
                modelName: "<?php  echo $angularModelFile; ?>"
            },
        }).then(function successCallback(response) { 
                $scope.Req = ""; 
                $scope.errorName, $scope.errorCode, $scope.successUpdate = ""; 
                
                //$scope.Options = 3;
                console.log(response.data);

                if(response.data.resultCheckEdited != '0'){
                    $scope.userIsEditing = true;
                    $scope.userEmailEditing = response.data.resultCheckEmailUser;
                    $scope.editForms = false;

                    $scope.overwriteCode = response.data.Code;
                    $scope.overwritePrim = response.data.Prim;

                    return;
                }else{
                    $scope.userIsEditing = false; 
                }  




               // console.log($scope.userEmailEditing + $scope.userIsEditing);

                $scope.editForms = response.data;

                $scope.editForms.changeLogUpdate = {};


               

         
                
                //console.log(response.data.UpgradecomponentAPI.ComponentsResult.Components); 
                //console.log($scope.CheckEmpty(response.data.UpgradecomponentAPI.ComponentsResult.Components));

                if($scope.CheckEmpty(response.data.UpgradecomponentAPI.ComponentsResult.Components) == false){

                        if(response.data.UpgradecomponentAPI.ComponentsResult.Components.Component.length > 0){
                                //Component API Remove DC02
                                $scope.FirstAPIArrs = []
                                var apiObjBlank = {
                                    "Description01": "",
                                    "Description02": "",
                                    "StockCode": ""
                                }
                                $scope.FirstAPIArrs.push(apiObjBlank); 
                                $scope.editForms.ComponentAPIOne = response.data.UpgradecomponentAPI.ComponentsResult.Components.Component.map( function(apiObj){
                                    if(apiObj.ProductClass != 'DC02')
                                    { 
                                        $scope.FirstAPIArrs.push(apiObj); 
                                    }  
                                }); 
                                $scope.FirstAPI = $scope.FirstAPIArrs;

                                //Component API Remove DC01
                                $scope.SecondAPIArrs = []
                                var apiObjBlank2 = {
                                    "Description01": "",
                                    "Description02": "",
                                    "StockCode": ""
                                }
                                $scope.SecondAPIArrs.push(apiObjBlank2);

                                $scope.editForms.ComponentAPITwo = response.data.UpgradecomponentAPI.ComponentsResult.Components.Component.map( function(apiObj){
                                    if(apiObj.ProductClass != 'DC01')
                                    { 
                                        $scope.SecondAPIArrs.push(apiObj); 
                                    }  
                                }); 
                                $scope.SecondAPI = $scope.SecondAPIArrs;  
                        }else{
                            $scope.FirstAPI = response.data.UpgradecomponentAPI.ComponentsResult.Components.Component;
                            $scope.SecondAPI = response.data.UpgradecomponentAPI.ComponentsResult.Components.Component; 
                        } 

                }else{
                    $scope.FirstAPI = null;
                    $scope.SecondAPI = null; 
                }

                
               
 

                

                 /* releaseDate */
                 $scope.origStatus = $scope.editForms.Status;

                  /* status changer */ 
                $scope.statusChanger = function(origStatus, newStatus){
                    //console.log(origStatus + " / " + newStatus);
                   
                    if(origStatus != 'D' && newStatus == 'D'){
                        $scope.editForms.disableChange = true; 
                        $scope.editForms.changeType = '9';
                        $scope.editForms.ChangeDescription = 'Item marked to be discontinued';
                    }
                    if(origStatus == 'X' && newStatus == 'N'){
                        $scope.editForms.disableChange = true; 
                        $scope.editForms.changeType = '8';
                        $scope.editForms.ChangeDescription = 'New Item Released';
                    }
                }

                $scope.origActive = $scope.editForms.Active;

                $scope.activeChanger = function(origActive, newActive){
                    //console.log(origActive + " / " + newActive);
                    if(origActive == 1 && newActive == 0){
                        $scope.editForms.disableChange = true; 
                        $scope.editForms.changeType = '12';
                        $scope.editForms.ChangeDescription = 'Item no longer available';
                    }
                } 
                
                /* status changer */

                

                //FreightOptions
                $scope.freights = response.data.selectFreightOptions; 

                $scope.editForms.freightNumberSelected = []; 
                var arrayFreight;  
                $scope.selectionFreights = []; 
                if(response.data.freightOptions != null){
                    arrayFreight = response.data.freightOptions.split(','); 
                }else{
                    arrayFreight = null;
                }   

                $scope.selectionFreights = arrayFreight;
                $scope.editForms.freightNumberSelected = arrayFreight;

                 //Despatch Selection change
                $scope.origDespatch = response.data.despatchLocation; 
                $scope.despatchChange = function(despatchSelected){ 

                   $scope.selectionFreights.length = 0;
                   $scope.editForms.freightNumberSelected =  $scope.selectionFreights;   
 
                   if($scope.origDespatch == despatchSelected){
                        
                        //Redo the value
                        if(response.data.freightOptions != null){
                            arrayFreight = response.data.freightOptions.split(','); 
                        }else{
                            arrayFreight = null;
                        }   
                        $scope.selectionFreights = arrayFreight;
                        $scope.editForms.freightNumberSelected = arrayFreight;

                    } 
 
                }
                 

                $scope.toggleSelectionFreight = function (freightName) { 

                    if($scope.selectionFreights == null){
                        $scope.countAccess = parseInt(freightName);   
                        if($scope.countAccess >= 0){ 
                            var arrs = []; 
                            arrs.push(freightName);  
                        } 
                        $scope.selectionFreights = arrs;   
                    }else{
                        var idf = $scope.selectionFreights.indexOf(freightName);  
                        if (idf > -1) {
                            $scope.selectionFreights.splice(idf, 1); 
                        } 
                        // Is newly selected
                        else {
                            $scope.selectionFreights.push(freightName); 
                        } 
                    }  
                    $scope.editForms.freightNumberSelected =  $scope.selectionFreights;   
                }

                

                


                /* pricing loop default prices */ 
                $scope.changeLogs = [];
                $scope.autoComment = [];

                 //Additionalcostlog
                $scope.changeLogsAdditional = [];
                $scope.autoCommentAdditional = [];
                $scope.editForms['ChangeDescriptionPricingAdditional'] = [];
                $scope.editForms['changeTypePricingAdditional'] = [];
                $scope.addcostdesc1 = $scope.addcostdesc2 = $scope.addcostdesc3 = $scope.addcostdesc4 = $scope.addcostdesc5 = $scope.addcostdesc6 = $scope.addcostdesc7 = $scope.addcostdesc8 = $scope.addcostdesc9  = $scope.addcostdesc10 = $scope.addcostdesc11 = $scope.addcostdesc12= [];
                $scope.addcost1 = $scope.addcost2 = $scope.addcost3 = $scope.addcost4 = $scope.addcost5 = $scope.addcost6 = $scope.addcost7 = $scope.addcost8 = $scope.addcost9 = $scope.addcost10 = $scope.addcost11 = $scope.addcost12 = [];
                $scope.setupcharge1 = $scope.setupcharge2 = $scope.setupcharge3 = $scope.setupcharge4 = $scope.setupcharge5 = $scope.setupcharge6 = $scope.setupcharge7 = $scope.setupcharge8 = $scope.setupcharge9 = $scope.setupcharge10 = $scope.setupcharge11 = $scope.setupcharge12 = [];

                //console.log(response.data.pricingLoop); 
                $scope.pricingLoopCount = response.data.pricingLoop.length - 1;
                $scope.pricingLoopOriginal = [];
                $scope.editForms['ChangeDescriptionPricing'] = [];
                $scope.editForms['changeTypePricing'] = [];
                 
                $scope.collectAdditionalLogs = '';
                //console.log("Count here " + $scope.pricingLoopCount);


                //New Aug19
                $scope.addscost1  = $scope.addscost2 = $scope.addscost3 = $scope.addscost5 = $scope.addscost6 = $scope.addscost7 = $scope.addscost8 = $scope.addscost9 = $scope.addscost10 = $scope.addscost11 = $scope.addscost12 = false; 
                $scope.collectAdd1 = $scope.collectAdd2 = $scope.collectAdd3 = $scope.collectAdd4 = $scope.collectAdd5 = $scope.collectAdd6 = $scope.collectAdd7 = $scope.collectAdd8 = $scope.collectAdd9 = $scope.collectAdd10 = $scope.collectAdd11 = $scope.collectAdd12 = [];
                var mod1  = mod2 = mod3 = mod4 = mod5 = mod6 = mod7 = mod8 = mod9 = mod10 = mod11 = mod12 = false; 
                var collectAdd1 = collectAdd2 =  collectAdd3 =  collectAdd4 =  collectAdd5 =  collectAdd6 =  collectAdd7 =  collectAdd8 =  collectAdd9 =  collectAdd10 =  collectAdd11 =  collectAdd12 = '';
                $scope.addscostTick1 = $scope.addscostTick2 = $scope.addscostTick3 = $scope.addscostTick4 = $scope.addscostTick5 = $scope.addscostTick6 = $scope.addscostTick7 = $scope.addscostTick8 = $scope.addscostTick9 = $scope.addscostTick10 = $scope.addscostTick11 = $scope.addscostTick12 = [];
                 
                $scope.collectAdd = [];
                $scope.addscostTicks = {}; 
                $scope.trigger = [];
                $scope.collectAdditionalMessage = '';
                var collectAdditionalMessage = [];
                var totalStringToAdd = [];
                var varAdditionalCosts = [];
                    
                $scope.editForms['additionalCostSavedValues'] = [];

                $scope.addcostThisChanges = function(loopIndex, rowT, mods ){

                    $scope.collectAdd[loopIndex] += '';

                    //console.log($scope.editForms.additionalCostSavedValues[loopIndex])
                    varAdditionalCosts[loopIndex] = $scope.editForms.additionalCostSavedValues[loopIndex];
                    varAdditionalCosts[loopIndex] = varAdditionalCosts[loopIndex].split('~');
                    //Get the first array value
                    var intro = varAdditionalCosts[loopIndex][0];
                    //Remove the first array value
                    varAdditionalCosts[loopIndex].shift(); 
                    //console.log("Intro: " + intro);
                   //console.log(varAdditionalCosts[loopIndex]);
                    
                    
                    
                    if(rowT == 1){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][0] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][0] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }
                    if(rowT == 2){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][1] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][1] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 3){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][2] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][2] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 4){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][3] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][3] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 5){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][4] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][4] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 6){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][5] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][5] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 7){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][6] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][6] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 8){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][7] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][7] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 9){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][8] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][8] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 10){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][9] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][9] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 11){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][10] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][10] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    if(rowT == 12){ 
                        if(mods == true){ 
                            $scope.collectAdd[loopIndex]   += varAdditionalCosts[loopIndex][11] + ". ";
                        }else{
                            totalStringToAdd[loopIndex] = varAdditionalCosts[loopIndex][11] + ". "
                            totalString= $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex];
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString(totalString, totalStringToAdd[loopIndex]);  
                            $scope.collectAdd[loopIndex]  = $scope.removeAdditionalString($scope.collectAdd[loopIndex], intro);  
                        }
                    }

                    var finalCollectAdd =  intro + $scope.collectAdd[loopIndex].replace('undefined', ''); 

                    $scope.editForms.ChangeDescriptionPricingAdditional[loopIndex] =   finalCollectAdd;  

 
                    
                }   

                $scope.removeAdditionalString = function(totalString, value){
                        var str = totalString;
                        var newStr = str.replace(value, ''); 
                        return  newStr;
                }



                for(var pl = 0; pl <= $scope.pricingLoopCount; pl++){ 

                     
                    if(response.data.pricingLoop[pl].Price1 != 0){
                        $scope.LoopPrice1 = response.data.pricingLoop[pl].Price1;
                    }else{
                        $scope.LoopPrice1 = '';
                    }

                    if(response.data.pricingLoop[pl].Price2 != 0){
                        $scope.LoopPrice2 = response.data.pricingLoop[pl].Price2;
                    }else{
                        $scope.LoopPrice2 = '';
                    }

                    if(response.data.pricingLoop[pl].Price3 != 0){
                        $scope.LoopPrice3 = response.data.pricingLoop[pl].Price3;
                    }else{
                        $scope.LoopPrice3 = '';
                    }

                    if(response.data.pricingLoop[pl].Price4 != 0){
                        $scope.LoopPrice4 = response.data.pricingLoop[pl].Price4;
                    }else{
                        $scope.LoopPrice4 = '';
                    }

                    if(response.data.pricingLoop[pl].Price5 != 0){
                        $scope.LoopPrice5 = response.data.pricingLoop[pl].Price5;
                    }else{
                        $scope.LoopPrice5 = '';
                    }

                    if(response.data.pricingLoop[pl].Price6 != 0){
                        $scope.LoopPrice6 = response.data.pricingLoop[pl].Price6;
                    }else{
                        $scope.LoopPrice6 = '';
                    }

                    $scope.editForms['ChangeDescriptionPricing'][pl] = response.data.pricingLoop[pl].Currency + ' - ' + response.data.pricingLoop[pl].PricingType + ': Price Update: Original pricing ' + $scope.LoopPrice1 + ", " + $scope.LoopPrice2 + ", " +  $scope.LoopPrice3 + ", " +  $scope.LoopPrice4 + ", " +  $scope.LoopPrice5 + ", " +  $scope.LoopPrice6;
                    $scope.changeLogs[pl] = false;
                    $scope.autoComment[pl] = 'false'; 
                    $scope.editForms.changeTypePricing[pl] = "0"; 
                    $scope.editForms.changeTypePricingAdditional[pl] = "0";  
                    




                    //Additionalcostlog
                    $scope.changeLogsAdditional[pl] = false;
                    $scope.autoCommentAdditional[pl] = false; 

                  $scope.collectAdditionalLogs = "Additional Costs Update for " + response.data.pricingLoop[pl].Currency + " - " +   response.data.pricingLoop[pl].PricingType + ": Pricing was ~ ";

                   

                    $scope.addcostdesc1[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc1; 
                    $scope.addcost1[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost1; 
                    $scope.setupcharge1[pl] = $scope.editForms.pricingLoop[pl].SetupCharge1;
                    //console.log("PL = " + pl);

                    if($scope.addcostdesc1[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc1[pl] + " , " + $scope.addcost1[pl] + " , " +  $scope.setupcharge1[pl] + " ~ ";
                    }
                    
                    $scope.addcostdesc2[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc2;
                    $scope.addcost2[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost2;
                    $scope.setupcharge2[pl] = $scope.editForms.pricingLoop[pl].SetupCharge2;

                    if($scope.addcostdesc2[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc2[pl] + " , " + $scope.addcost2[pl] + " , " +  $scope.setupcharge2[pl] + " ~ ";
                    }

                    $scope.addcostdesc3[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc3;
                    $scope.addcost3[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost3;
                    $scope.setupcharge3[pl] = $scope.editForms.pricingLoop[pl].SetupCharge3;

                    if($scope.addcostdesc3[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc3[pl] + " , " + $scope.addcost3[pl] + " , " +  $scope.setupcharge3[pl] + " ~ ";
                    }
                    

                    $scope.addcostdesc4[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc4;
                    $scope.addcost4[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost4;
                    $scope.setupcharge4[pl] = $scope.editForms.pricingLoop[pl].SetupCharge4;

                    if($scope.addcostdesc4[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc4[pl] + " , " + $scope.addcost4[pl] + " , " +  $scope.setupcharge4[pl] + " ~ ";
                    }


                    $scope.addcostdesc5[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc5;
                    $scope.addcost5[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost5;
                    $scope.setupcharge5[pl] = $scope.editForms.pricingLoop[pl].SetupCharge5;

                    if($scope.addcostdesc5[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc5[pl] + " , " + $scope.addcost5[pl] + " , " +  $scope.setupcharge5[pl] + " ~ ";
                    }

                    $scope.addcostdesc6[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc6;
                    $scope.addcost6[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost6;
                    $scope.setupcharge6[pl] = $scope.editForms.pricingLoop[pl].SetupCharge6;

                    if($scope.addcostdesc6[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc6[pl] + " , " + $scope.addcost6[pl] + " , " +  $scope.setupcharge6[pl] + " ~ ";
                    }

                    $scope.addcostdesc7[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc7;
                    $scope.addcost7[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost7;
                    $scope.setupcharge7[pl] = $scope.editForms.pricingLoop[pl].SetupCharge7;

                    if($scope.addcostdesc7[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc7[pl] + " , " + $scope.addcost7[pl] + " , " +  $scope.setupcharge7[pl] + " ~ ";
                    }

                    $scope.addcostdesc8[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc8;
                    $scope.addcost8[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost8;
                    $scope.setupcharge8[pl] = $scope.editForms.pricingLoop[pl].SetupCharge8;

                    if($scope.addcostdesc8[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc8[pl] + " , " + $scope.addcost8[pl] + " , " +  $scope.setupcharge8[pl] + " ~ ";
                    }

                    $scope.addcostdesc9[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc9;
                    $scope.addcost9[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost9;
                    $scope.setupcharge9[pl] = $scope.editForms.pricingLoop[pl].SetupCharge9;

                    if($scope.addcostdesc9[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc9[pl] + " , " + $scope.addcost9[pl] + " , " +  $scope.setupcharge9[pl] + " ~ ";
                    }

                    $scope.addcostdesc10[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc10;
                    $scope.addcost10[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost10;
                    $scope.setupcharge10[pl] = $scope.editForms.pricingLoop[pl].SetupCharge10;

                    if($scope.addcostdesc10[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc10[pl] + " , " + $scope.addcost10[pl] + " , " +  $scope.setupcharge10[pl] + " ~ ";
                    }

                    $scope.addcostdesc11[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc11;
                    $scope.addcost11[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost11;
                    $scope.setupcharge11[pl] = $scope.editForms.pricingLoop[pl].SetupCharge11;

                    if($scope.addcostdesc11[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc11[pl] + " , " + $scope.addcost11[pl] + " , " +  $scope.setupcharge11[pl] + " ~ ";
                    }

                    $scope.addcostdesc12[pl] = $scope.editForms.pricingLoop[pl].AdditionalCostDesc12;
                    $scope.addcost12[pl] = $scope.editForms.pricingLoop[pl].AdditionalCost12;
                    $scope.setupcharge12[pl] = $scope.editForms.pricingLoop[pl].SetupCharge12;

                    if($scope.addcostdesc12[pl]){  
                        $scope.collectAdditionalLogs += $scope.addcostdesc12[pl] + " , " + $scope.addcost12[pl] + " , " +  $scope.setupcharge12[pl] + " ~ ";
                    }
                    //console.log($scope.collectAdditionalLogs)
                    //Add this new aug20
                    $scope.editForms.additionalCostSavedValues[pl] = $scope.collectAdditionalLogs;

                    // $scope.editForms.ChangeDescriptionPricingAdditional[pl] = $scope.collectAdditionalLogs; 

                    /* Additional costlog */

                }
                
                $scope.insertChangeLog = function(opt, currn, types, toggles){
                    //console.log("on - " + toggles); 
                    if( opt == 1){
                        //Toogle On and OFf
                        $scope.changeLogs[toggles] = true;
                        $scope.autoComment[toggles] = true;
                        
                        if(currn == 'NZD'){ 
                             //$scope.editForms.changeType =  "1";
                             $scope.editForms.changeTypePricing[toggles] = "1";
                        }
                        if(currn == 'AUD'){ 
                             //$scope.editForms.changeType =   "7";
                             $scope.editForms.changeTypePricing[toggles] = "7";
                        }
                        if(currn == 'SGD'){  
                             $scope.editForms.changeTypePricing[toggles] = "13";
                        }
                        if(currn == 'MYR'){  
                             $scope.editForms.changeTypePricing[toggles] = "14";
                        }
                    }else{
                        $scope.autoComment[toggles]  = 'false';   
                        $scope.changeLogs[toggles] = false;
                        $scope.editForms.disableChange = false; 
                        $scope.editForms.ChangeDescription = '';
                        $scope.editForms.changeType =  "";
                        $scope.editForms.changeTypePricing[toggles] = "0"; 
                        //console.log("off - " + toggles);
                    } 
                }

                //Additionalcostlog

                //Get the record additional cost 

                
                 
               
                
                $scope.insertChangeLogAdditionalCost = function(opt, currn, loops, type,   toggles){
                    if( opt == 1){  
                         
                        //console.log($scope.editForms.pricingLoop);
                        //console.log("OPEN");  
                        //console.log(loops);
                        $scope.changeLogsAdditional[toggles] = true;
                        $scope.autoCommentAdditional[toggles] = true;

                        
                        if(currn == 'NZD'){  
                             $scope.editForms.changeTypePricingAdditional[toggles] = "1";
                        }
                        if(currn == 'AUD'){  
                             $scope.editForms.changeTypePricingAdditional[toggles] = "7";
                        }


                        $scope.editForms.additionalCostLogActive = 1; 
                       

                    }else{
                        //console.log("CLOSE");
                        $scope.changeLogsAdditional[toggles] = false;
                        $scope.autoCommentAdditional[toggles] = false;
                        $scope.editForms.disableChange = false; 
                        $scope.editForms.ChangeDescription = '';
                        $scope.editForms.changeType =  "";
                        $scope.editForms.changeTypePricingAdditional[toggles] = "0"; 
                        //$scope.collectAdditionalLogs = '';
                    }
                }
                

                $scope.changeTab = function(e, inputRow, eNum, pl, ind) { 
                   // console.log(" THIS  "   + pl + " / " + ind);
                    /*var pl = pl || null; 
                    var inputRow = inputRow || null;
                    var eNum = eNum || null; */

                    if (e.keyCode == 9){ 
                        var nextTab; 
                       
                        if(eNum == 1){ 
                            var additionalCount = 6; 
                            nextTab = inputRow + 1;  
                            nextTab = nextTab - 1;
                            // console.log("One " + inputRow +  " .quantity" + nextTab);
                            angular.element('.quantitys' + nextTab).focus();    
                            if(nextTab > additionalCount){
                                angular.element('.Price1').focus();     
                            }
                        }

                        if(eNum == 2){ 
                            var additionalCount = 6; 
                            nextTab = inputRow + 1;  
                            //console.log("TWO  " + inputRow +  "  .Price" + nextTab + pl + ind);
                            angular.element('.Price' + nextTab + pl + ind).focus();    
                            if(nextTab > additionalCount){
                                //angular.element('.'+currs+'priceSummary1').focus();   
                            }
                        } 
 

                    } 
                } 

                 $scope.changeAdditionalTab = function(e, inputRow, eNum) { 
                    if (e.keyCode == 9){ 
                        var nextTab; 
                        //console.log("eto " + eNum);
                        angular.element('.setupcharge' + eNum).focus();    

                    } 
                } 

                 $scope.pricingFocus = function(val, priceLoops, loopCount) { 
                   // console.log("eto " + val + "/" + loopCount);
                    if(val == '0.00' && loopCount == 1){
                        $scope.editForms.pricingLoop[priceLoops].Price1 = '';
                    }
                    if(val == '0.00' && loopCount == 2){
                        $scope.editForms.pricingLoop[priceLoops].Price2 = '';
                    }
                    if(val == '0.00' && loopCount == 3){
                        $scope.editForms.pricingLoop[priceLoops].Price3 = '';
                    }
                    if(val == '0.00' && loopCount == 4){
                        $scope.editForms.pricingLoop[priceLoops].Price4 = '';
                    }
                    if(val == '0.00' && loopCount == 5){
                        $scope.editForms.pricingLoop[priceLoops].Price5 = '';
                    }
                    if(val == '0.00' && loopCount == 6){
                        $scope.editForms.pricingLoop[priceLoops].Price6 = '';
                    }
                 }

                 //Additional Pricing user experience task
                $scope.perUnitFocus = function(val, priceloops, vars, num) {  
                   if(val == '0.00' || val == '0'){  
                       //AddCost
                       if(vars == 'addcost'){
                            if(num == 1){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost1 = '';
                            } 
                            if(num == 2){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost2 = '';
                            } 
                            if(num == 3){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost3 = '';
                            } 
                            if(num == 4){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost4 = '';
                            } 
                            if(num == 5){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost5 = '';
                            } 
                            if(num == 6){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost6 = '';
                            } 
                            if(num == 7){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost7 = '';
                            } 
                            if(num == 8){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost8 = '';
                            } 
                            if(num == 9){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost9 = '';
                            } 
                            if(num == 10){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost10 = '';
                            } 
                            if(num == 11){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost11 = '';
                            } 
                            if(num == 12){
                                $scope.editForms.pricingLoop[priceloops].AdditionalCost12 = '';
                            } 
                       }
                       if(vars == 'setupcharge'){
                            if(num == 1){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge1 = '';
                            } 
                            if(num == 2){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge2 = '';
                            } 
                            if(num == 3){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge3 = '';
                            } 
                            if(num == 4){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge4 = '';
                            } 
                            if(num == 5){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge5 = '';
                            } 
                            if(num == 6){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge6 = '';
                            } 
                            if(num == 7){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge7 = '';
                            } 
                            if(num == 8){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge8 = '';
                            } 
                            if(num == 9){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge9 = '';
                            } 
                            if(num == 10){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge10 = '';
                            } 
                            if(num == 11){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge11 = '';
                            } 
                            if(num == 12){
                                $scope.editForms.pricingLoop[priceloops].SetupCharge12 = '';
                            } 
                       }

                       //SetupCharge  
                    } 
                 }
                //Additional Pricing user experience task






                /* pricing loop default prices */ 


                /* Images */ 
                $scope.editImagesActive = true;
                $scope.editImageForm = {};
                $scope.editImagePrim = response.data.Prim;
                $scope.editImageID = id;
                $scope.editImageCode = response.data.Code;
                $scope.editImageCountNew = response.data.ImageCountNew;  
                $scope.editImageCountOrig = response.data.ImageCount; 
                $scope.uploadImage;
                $scope.editImageForm.selectImageToReplace = 'main';
                $scope.productStocks = response.data.productStocks; 
                $scope.coloursSelects = response.data.coloursSelects; 
                $scope.random = Math.random();

                    $scope.form = [];
                    $scope.files = []; 
                    $scope.uploadFile = function(file){   
                        
                        console.log($scope.editImageForm.FormFile);
                        var form_data = new FormData();  
                        console.log(form_data);
                            
                        if(file){
                            file.upload = Upload.upload({
                                url: '<?php echo $angularPost; ?>',
                                data: {option:  11, addfiles: file, editImageCountNew:$scope.editImageCountNew, editImageID: $scope.editImageID, editImageCode:$scope.editImageCode, formCondition: $scope.editImageForm.FormFile, editImagePrim: $scope.editImagePrim    },
                            });

                            file.upload.then(function (responseImage) {  
                                //console.log("HERE IS SUCCESS XXX");
                                console.log(responseImage.data);

                                if(responseImage.data == 0){
                                    alert("Please upload JPEG file only");
                                return;
                                }
                                $scope.selectItem($scope.editImagePrim); 
                                var element = angular.element('#successModal'); 
                                element.modal('show'); 
                                $scope.successMsg = 'Image Uploaded';
                                $timeout(function() {
                                    element.modal('hide'); 
                                }, 900);   
                                
                                //Image upload to 470  CI controller
                                var ImageCodeSend = $scope.editImageCode + "/" + $scope.editImageCountNew + "?option=1";
                                var UrlImgController = "/resizerimage/" + ImageCodeSend;
                                $http({
                                            method: "post",
                                            url:  UrlImgController,
                                            data: {imgCode:$scope.editImageCode}
                                }).then(function successCallback(responseImg) {  
                                            //console.log("NEw count " + $scope.editImageCountNew);
                                            console.log("Uploaded to 470 " + responseImg.data);  
                                }, function errorCallback(response) {
                                            alert(response + " Error creating 470 images");
                                });  
                                

                            }, function (response) {
                            if (response.status > 0)
                                $scope.errorMsg = response.status + ': ' + response.data;
                            });
                        } 
                    


                    }     



                /* Images */



                

                //Start ProductStock 
                
                $scope.editStocks = {};
                $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {code:response.data.Code, option: 10}
                }).then(function successCallback(stocks) { 
                            //console.log(stocks.data);
                            //console.log(stocks.data.length);
                            if(stocks.data){
                                $scope.editForms.productStocks = stocks.data;
                                $scope.editStocks = stocks.data; 
                            } 
                }, function errorCallback(response) {
                            alert(response + " Error updating the data");
                });  

                //End ProductStock


                
                //Preview Table 
                $scope.previewTable(response.data.sizingLine1, response.data.sizingLine2, response.data.sizingLine3, response.data.sizingLine4);

                //Pricing
                $scope.formPricingSubmitted(response.data.Prim, response.data.Name, response.data.Code, null, null, response.data.pricingCount, '0', response.data.pricingCount);
                $scope.getPricingAdditionalCount(response.data.Code, 'default'); 

                $scope.updateData = function() {   

                    //Pass variable from prodyuct Stock to editForms 
                    
                    $scope.editForms.productStocks = $scope.editStocks;
                    
                      
                     console.log("$scope.editForms", $scope.editForms);

                     console.log($scope.editForms.UpgradeFilteredAdditionalList);
                     

                     //releaseDate
                     
                     $scope.editForms['origStatus'] = $scope.origStatus;
                    
                    $http({
                            method: "post",
                            url:  "<?php  echo $angularPost; ?>",
                            data: $scope.editForms  
                        }).then(function successCallback(good) {
                            console.log(good.data);  
                                
                           //console.log(good.data.error.Code) 
                            if(good.data.error)
                            { 
                                $scope.errorName = good.data.error.Name; 
                                $scope.errorCode = good.data.error.Code;
                                $scope.errorchangeType = good.data.error.changeType; 
                                $scope.errorChangeDescription = good.data.error.ChangeDescription;
                                //$scope.errorAdditionalCostx = good.data.error.AdditionalCostx; 
                                //$scope.errorSetupChargex = good.data.error.SetupChargex; 
                                $scope.errorCartonLength = good.data.error.CartonLength;
                                $scope.errorCartonWidth = good.data.error.CartonWidth;
                                $scope.errorCartonHeight = good.data.error.CartonHeight;
                                $scope.errorCartonQuantity = good.data.error.CartonQuantity;

                                $scope.icon1 = true;
                                $scope.icon2 = false;
                                $scope.successUpdate = good.data.message; 
                                
                            }
                            else
                            { 

                                 
                                 

                                $scope.errorName = null;
                                $scope.errorCode = null;
                                $scope.errorchangeType = null; 
                                $scope.errorChangeDescription = null;
                                //$scope.errorAdditionalCostx = null;
                            // $scope.errorSetupChargex = null;
                                //$scope.icon = 2;
                                $scope.errorCartonLength = null;
                                $scope.errorCartonWidth = null;
                                $scope.errorCartonHeight = null;
                                $scope.errorCartonQuantity = null;
                                
                                $scope.icon1 = false;
                                $scope.icon2 = true;
                                var element = angular.element('#successModal'); 
                                element.modal('show'); 
                                $scope.successMsg = good.data.message;
                                

                               
                               

                                //var URL = "http://localhost/refresh/all";    
                                //window.open(URL, "_blank") 

                                 
                                $timeout(function() {
                                    $scope.icon2 = false;
                                    element.modal('hide'); 
                                }, 2000);

                                $scope.selectItem(id);
                                //$scope.successUpdate = good.data.message;

                                 //New changelog
                                $scope.countChangeLog = 1;
                                $scope.changeLogLooping('refresh');
                                
                                
                                $http({
                                    method: "post",
                                    url:  $scope.urlRefresh,
                                    data:  null
                                    }).then(function successCallback(refresh) {
                                            console.log("Refreshed!");   
                                        }, function errorCallback(response) { 
                                        alert(" Error Refreshing Cache");
                                }); 





                                    

                            }    
                                
                        }, function errorCallback(response) { 
                            alert(" Error updating the data");
                    }); 
                }

                $scope.count = 0;
                $scope.plusCount = function(pars, num, size ){
                    var num = num || null;
                    var size = size || null; 
                
                    if(num != null && size == null){ 
                        $scope.count = num - 1;
                    // console.log("num only " + $scope.count);
                    }
                    if (pars == "plus"){ 
                        if($scope.editForms.sizingLine1 != null || $scope.editForms.sizingLine2 != null){   
                                //console.log(" pasok " + $scope.count);
                                $scope.count = parseInt($scope.count) + 1;  
                        }
                    }else{
                        if($scope.count > 0){
                            $scope.count = parseInt($scope.count) - 1; 
                            //console.log($scope.count); 
                            if(size == "sizetrue"){
                                $scope.editForms.sizeArray[$scope.count] = null;
                                $scope.editForms.sizeArray2[$scope.count] = null;
                            }else{ 
                                if($scope.editForms.sizingValA != undefined || $scope.editForms.sizingValB != undefined){
                                    $scope.editForms.sizingValA[$scope.count] = null;
                                    $scope.editForms.sizingValB[$scope.count] = null;
                                }  
                            }    
                        }   
                    } 
                    if($scope.count >= 0){
                        var arr = []; 
                        for (var i = 0; i < $scope.count; i++) {   
                            if(num != null){ 
                                if(i != 0){
                                    arr.push(i);
                                }
                            }else{
                                arr.push(i);
                            }
                        
                        } 
                        
                        $scope.inputInc = arr;
                    } 
                }

                $scope.count2 = 0;
                $scope.plusCount2 = function(pars2, num2, size2){
                    var num2 = num2 || null;
                    var size2 = size2 || null;
                
                if(num2 != null && size2 == null){ 
                    $scope.count2 = num2 - 1;
                    //console.log("num only " + $scope.count2);
                }
                if (pars2 == "plus"){ 
                    if($scope.editForms.sizingLine3 != null || $scope.editForms.sizingLine4 != null){   
                            //console.log(" pasok " + $scope.count2);
                            $scope.count2 = parseInt($scope.count2) + 1; 
                    }
                }else{
                    if($scope.count2 > 0){
                        $scope.count2 = parseInt($scope.count2) - 1; 
                        //console.log($scope.count); 
                        if(size2 == "sizetrue"){
                            $scope.editForms.sizeArray3[$scope.count2] = null;
                            $scope.editForms.sizeArray4[$scope.count2] = null;
                        }else{
                                if($scope.editForms.sizingValC != undefined || $scope.editForms.sizingValD != undefined){
                                    $scope.editForms.sizingValC[$scope.count2] = null;
                                    $scope.editForms.sizingValD[$scope.count2] = null;
                                }
                        }    
                    }   
                } 
                if($scope.count2 >= 0){
                    var arr2 = []; 
                    for (var x = 0; x < $scope.count2; x++) {   
                        if(num2 != null){ 
                                if(x != 0){
                                arr2.push(x);
                                }
                        }else{
                            arr2.push(x);
                        } 
                    } 
                    $scope.inputInc2 = arr2;
                } 
            } 

                

                //Branding Loop input 
                

                $scope.count3 = 0;
                $scope.plusPrintDec = function(pars3, num3, size3){
                    var num3 = num3 || null;
                    var size3 = size3 || null;
                
                if(num3 != null && size3 == null){ 
                    $scope.count3 = num3;
                        //console.log("num only " + $scope.count3);
                }
                if (pars3 == "plus"){   
                    if($scope.count3 <= 10){
                            $scope.count3 = parseInt($scope.count3) + 1;  
                    }       
                }else{
                        //console.log("Bawas  " + $scope.count3);
                    if($scope.count3 > 2){ 
                            if($scope.count3 != 0){ 
                                    $scope.count3 = parseInt($scope.count3) - 1;   
                                    $scope.editForms.printTypes[$scope.count3] = null;
                                    $scope.editForms.PrintDescriptions[$scope.count3] = null; 
                            }
                    }   
                } 
                if($scope.count3 >= 0){
                    var arr3 = []; 
                    for (var x = 1; x < $scope.count3; x++) {   
                        if(num3 != null){ 
                                if(x != 0){
                                arr3.push(x);
                                }
                        }else{
                            arr3.push(x);
                        } 
                    } 
                    //console.log("Final  " + arr3);
                    $scope.ptIncrements = arr3;
                } 
            } 



                $scope.defaultValues = function(val){
                    if(val == '' || val == null){
                        $scope.defaultZero = 0;
                    }
                }


                // $scope.selectedChecked = []; 
                $scope.checkboxChecked = function(val, cols){ 
                    
                        var countVal = val.length;  
                        var v;
                        for (v = 0; v < countVal; v++) {  
                                var entr = val[v].toLowerCase();
                                if(entr == cols){
                                    console.log(entr + ' = ' + cols);  
                                    return true;
                                }  
                        }  
                }

                var selectedChecked = [];
                var arrayColoursA =[];
                var selectedCheckedB = false;
                $scope.selectedCheckedA = true;
                
                $scope.selectCheckbox = function(colour){ 
                    //console.log(colour);
                    var myId1 = angular.element( document.querySelector('.hide-' + colour) );
                    var myId2 = angular.element( document.querySelector('.show-' + colour) );

                    if($scope.editForms.selectedCheckedOneValues != null){   
                        var arrayColoursA = $scope.editForms.selectedCheckedOneValues.split(','); 
                    // console.log("Not undefined = "); 
                        arrayColoursA = arrayColoursA.filter(Boolean);
                        //console.log(arrayColoursA);
                        arrayColoursA.push(colour);
                        var finString = arrayColoursA.toString();
                        $scope.editForms.selectedCheckedOneValues  = finString;

                        $scope.showSample = finString.replace(/,/g , " ");

                        myId1.addClass('displaynone'); 
                        myId1.removeClass('displayinline-block'); 
                        myId2.addClass('displayinline-block');
                        myId2.removeClass('displaynone');  

                        
                    
                    }else{  
                        selectedChecked.push(colour);   
                        //console.log(selectedChecked);
                        $scope.editForms.selectedCheckedOneValues  = selectedChecked + ',';
                        myId1.addClass('displaynone'); 
                        myId1.removeClass('displayinline-block');
                        myId2.addClass('displayinline-block');
                        myId2.removeClass('displaynone');  

                        $scope.showSample = $scope.editForms.selectedCheckedOneValues.replace(/,/g , " ");
                    
                    }      
                    
                }
                
                $scope.removeCheck = function(colour, event){ 
                    //console.log($scope.editForms.selectedCheckedOneValues);  
                    var myId3 = angular.element( document.querySelector('.show-' + colour) );
                    var myId4 = angular.element( document.querySelector('.hide-' + colour) );

                    var arrayColours = $scope.editForms.selectedCheckedOneValues.split(','); 
                    arrayColours = arrayColours.filter(Boolean);
                    //console.log(arrayColours); 
                    var index = arrayColours.indexOf(colour);
                    //console.log(index);
                    arrayColours.splice(index, 1);
                    var finString = arrayColours.toString();
                    //console.log(finString); 
                    //console.log(arrayColours);
                    $scope.editForms.selectedCheckedOneValues = finString;  
                    myId3.addClass('displaynone'); 
                    myId3.removeClass('displayinline-block');
                    myId4.addClass('displayinline-block');
                    myId4.removeClass('displaynone'); 

                    $scope.showSample = finString.replace(/,/g , " ");
                }
                
                /* $scope.selectChange = {
                    isDisabled: true
                };
                $scope.changelog = function(){ 
                    $scope.selectChange = {
                        isDisabled:false
                    };
                } */


                //Run scope Function $scope.plusCount every click on new item
                if(response.data){
                    //alert(response.data.sizeCount1); 
                    if(response.data.sizeCount1){
                        if(response.data.sizeCount1 != undefined){ 
                            $scope.plusCount("plus", response.data.sizeCount1);
                        } 
                    }else{
                            $scope.plusCount("plus", 1);
                    } 

                    if(response.data.sizeCount3){
                        if(response.data.sizeCount3 != undefined){ 
                            $scope.plusCount2("plus", response.data.sizeCount3);
                        } 
                    }else{
                            $scope.plusCount2("plus", 1);
                    } 

                    if(response.data.PrintTypeCount){
                        if(response.data.PrintTypeCount != undefined){ 
                            $scope.plusPrintDec("plus", response.data.PrintTypeCount); 
                        
                        } 
                    }else{
                            $scope.plusPrintDec("plus", 1);
                            
                    } 
                }  

                $scope.updatePageTracking = function(itemCode, userID, pageTrack){
                    //console.log(itemCode + userID + pageTrack);

                    $http({
                        method: "post",
                        url:  "<?php echo $angularPost; ?>",
                        data: {
                            itemCode: itemCode,
                            userID: userID,
                            option: 4,
                            pageTrack: pageTrack
                        },
                    }).then(function successCallback(responseTrack) { 
                            //console.log(responseTrack.data);
                            //console.log(responseTrack.data.exists);
                            if(responseTrack.data.exists == '2'){
                                //alert("Someone is editing this item");
                                var emailUser = responseTrack.data.resultCheckEmailUser;
                                alert("This item is currently being edited by user " + emailUser);
                            }
                        // if(responseTrack.data.exists == 1){     
                        // }
                            
                    }, function errorCallback(responseTrack) {
                        alert("Error retrieving the data");
                    });
                }

                
                


        }, function errorCallback(response) {
            
            alert(" Error retrieving the data");
        }); 



        
                
    

    }  


//PRICING MAIN SCOPE

//$scope.selectCurrencyPricing = {'NZD':"NZD", 'Stock':"Stock", 'Indent - Air':"Indent - Air", 'Indent - Sea':"Indent - Sea"};
            //$scope.selectCurrencyPricing = {'NZD':"NZD", 'AUD':"AUD" };
            $scope.selectCurrencyPricing = $scope.currencyDatas;
            $scope.selectTypesPricing = { 'Stock': "Stock", 'Indent - Air':"Indent - Air", 'Indent - Sea':"Indent - Sea"}; 
            $scope.selectPrimaryPriceDescription = { 'U': "Unbranded", 'N':"Unbranded – no branding available", 'B':"Branded Price"};
            $scope.countDefault = 0;  
            $scope.formPricingTable = {};
            $scope.formPricingSubmitted = function(prim, name, code, currencyPrice, pricingPrice, princeCount, adds, totalPrice){
                        var princeCount = princeCount || null;
                        var currencyPrice = currencyPrice|| null;
                        var pricingPrice = pricingPrice|| null; 
                        var adds = adds || null; 
                        var  totalPrice =  totalPrice || null;

                        //console.log(prim+ ' / ' + name+ ' / ' + code+ ' / ' + currencyPrice+ ' / ' + pricingPrice+ ' / ' +  princeCount+ ' / ' + adds +   ' / ' + totalPrice ); 

                

                 if(princeCount == null && currencyPrice == null && pricingPrice == null ){
                     return;
                 }

                 if(adds > 0){
                     //console.log("ADD " + adds);
                     var totalAdds = totalPrice  + 1;
                        $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {
                                name: name,
                                code: code,
                                currencyPrice: currencyPrice,
                                pricingPrice: pricingPrice,
                                totalAdds: totalAdds,
                                option: 6, 
                            },
                        }).then(function successCallback(responseAdd) { 
                            //console.log(responseAdd.data + prim);
                            $scope.formPricingTable.CurrencyPricingModel = '';
                            $scope.formPricingTable.TypesPricingModel = '';
                            $scope.updateData();
                            $scope.selectItem(prim);
                              
                        }, function errorCallback(responseAdd) {
                            alert("Error retrieving the data");
                        });

                 }   
                if(princeCount){ 
                        $scope.countDefault = princeCount - 1;
                        $scope.countDefault = parseInt($scope.countDefault) + 1; 
                        //console.log("Here 1 " + totalPrice);
                    
                }else{
                        if(totalPrice){
                            $scope.countDefault = totalPrice;
                        }
                        $scope.countDefault = parseInt($scope.countDefault) + 1;   
                        //console.log("Here 2 " + $scope.countDefault);
                } 
                //console.log(name + ' / ' + currencyPrice + ' / ' + pricingPrice); 
                //console.log($scope.countDefault);
                if($scope.countDefault >= 0){
                        var priceArr = [];   
                        for (var x = 0; x < $scope.countDefault; x++) {    
                                priceArr.push(x);  
                        }  
                        
                        $scope.pricingIncrements = priceArr;    
                        //console.log($scope['editForms']['pricingLoop'][2]);  

                        /* Check the changes pricing */    
                        //console.log($scope.pricingIncrements);    
                }  
            }  



            
            /********UPGRADE CMS ************/
            
            //ADDTIONAL AND BRANDING SECTION
            $scope.addNewBrandingAdditionalCost = function(prim,  code, pricingtype, level){
                if (confirm("Note: This will create a new Branding and Additional Cost. Please click OK to continue. ")) { 
                    //console.log($scope.editForms); 
                    //console.log(prim + " / "  + code + " / " + pricingtype + " / " + level);
                    //console.log($scope.editForms.UpgradeFilteredAdditionalList);
                    $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {  
                                code: code,
                                pricingtype: pricingtype,
                                level: level,
                                additionalBranding: $scope.editForms.UpgradeFilteredAdditionalList,  
                                option: 22, 
                            },
                        }).then(function successCallback(newBranding) { 

                            $scope.editForms.UpgradeFilteredAdditionalList[level] = newBranding.data
                            console.log($scope.editForms.UpgradeFilteredAdditionalList);  
                               
                        }, function errorCallback(newBranding) {
                            alert("Error adding new branding and additional cost");
                    });  

                }
            }

            $scope.removeAddsBranding = function(prim, id){
                if (confirm("Are you sure you want to delete  this  Branding & Additional Cost?")) { 
                    console.log(prim + "/" + id);

                     $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {  
                                prim: prim,
                                id: id, 
                                option: 23
                            },
                        }).then(function successCallback(delBranding) {  
                            console.log(delBranding.data);  
                            if(delBranding.data == "done"){
                                $scope.selectItem(prim);
                            }
                               
                        }, function errorCallback(delBranding) {
                            alert("Error deleting branding and additional cost");
                    });  


                }
            }

            $scope.cancelNewAddBranding= function(prim){
                if (confirm("Are you sure you want to cancel new Additional Cost and Branding? Cancelling this will ignore all your changes")) { 
                    $scope.selectItem(prim);
                } 
            }

            $scope.getTheAdditionalOptionCategory = function(upgradeAdds, ind,  addOptCat){
                //console.log(upgradeAdds + "/" + ind + "/" + addOptCat);   
                var addOptCatFinal = null;
                if(addOptCat == "DO"){
                    addOptCatFinal = "Decoration Option";
                }
                if(addOptCat == "OE"){
                    addOptCatFinal = "Optional Extra";
                }
                if(addOptCat == "DCOE"){
                    addOptCatFinal = "Decoration Charge on Optional Extra";
                } 
                $scope.editForms.UpgradeFilteredAdditionalList[upgradeAdds][ind].additionalOptionCategory = addOptCatFinal;
            }

            // PRICING SECTION
            $scope.formPricingSubmittedUpgrade = function(prim, name, code, pricingtype ){
                if (confirm("Note: This will create a new pricing. Please click OK to continue. ")) { 
                    
                    if($scope.formPricingTable.TypesPricingModel){
                        console.log($scope.editForms); 
                    }
                    
                    $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: { 
                                name: name,
                                code: code,
                                pricingtype: pricingtype,
                                editForms: $scope.editForms,  
                                option: 21, 
                            },
                        }).then(function successCallback(newPricing) { 
                            console.log(newPricing.data); 

                            $scope.editForms.UpgradeFilteredPricing = newPricing.data.UpgradeNewFilterPricing;
                            $scope.editForms.UpgradeFilterKeys = newPricing.data.UpgradeNewFilterKeys;

                            $scope.hideNewForm = true;
                             console.log($scope.editForms); 
                            
                             
                               
                        }, function errorCallback(newPricing) {
                            alert("Error adding new pricing");
                    });  
                }
            } 

            $scope.formAdditionalBrandingSubmittedUpgrade = function(prim, name, code, pricingtype){
                
                console.log($scope.editForms.UpgradeFilterKeys);
                
               
                if(pricingtype && code){
                   
                    var increment = 0; 
                    var arr = [];
                    var countAdds = 0;

                    if($scope.editForms.UpgradeAddOptionsCount == 0){
                        $scope.editForms.UpgradeFilteredAdditionalList = [];
                        countAdds = 0;  
                        $scope.editForms.UpgradeAddOptionsCount = 1; 
                        $scope.editForms.UpgradeFilterKeys = [0];
                        

                    }else{ 
                        countAdds = $scope.editForms.UpgradeFilteredAdditionalList.length;
                        if($scope.editForms.UpgradeFilteredAdditionalList.length == 0 || $scope.editForms.UpgradeFilteredAdditionalList.length == ""){
                            countAdds = 0;
                        }   
                        increment = $scope.editForms.UpgradeFilterKeys.length + 1;

                        for(var x = 0; x < increment; x++){
                            arr.push(x);
                        }  
                        $scope.editForms.UpgradeFilterKeys = arr; 

                    }
                    
                     
                   $scope.editForms.UpgradeFilteredAdditionalList[countAdds] = [{  
                        'ProductCode': code,
                        'PricingType':  pricingtype,
                        'AUDOrderPrice': 0,
                        'AUDUnitPrice': 0.00,
                        'MYROrderPrice': 0,
                        'MYRUnitPrice': 0.00,
                        'NZDOrderPrice': 0,
                        'NZDUnitPrice': 0.00,
                        'SGDOrderPrice': 0,
                        'SGDUnitPrice': 0.00,
                        'additionalOptionCategory': "",
                        'brandingArea': "",
                        'brandingMethod': "",
                        'costDescription': "",
                        'maxPerUnit': "",
                        'orderRow': 1,
                        'pricePerOrderCode': "",
                        'pricePerUnitItemCode': "",
                        'brandAdditionalNew': 1
                     }]; 

                 
                }
            }

            $scope.removePricingCurrency = function(prim, ind, code, currency){
                if (confirm("Are you sure you want to delete  this  " + code + " - " + currency + " pricing?")) { 
                    //console.log(ind + " / " + currency);
                    $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {
                                prim: prim,
                                ind: ind,
                                code: code,
                                currency: currency,
                                option: 19, 
                            },
                        }).then(function successCallback(deletePricing) { 
                            //console.log(deletePricing.data);

                            if(deletePricing.data == "done"){
                                $scope.selectItem(prim);
                            }
                               
                        }, function errorCallback(deletePricing) {
                            alert("Error deleting this Currency");
                    });   
                }
            }


            $scope.removePricingUpgrade = function(prim, code, pricingtype){

                if (confirm("Are you sure you want to delete   " + code + " - " + pricingtype + "?")) { 
                    //console.log(code + " / " + pricingtype);
                    $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: { 
                                code: code,
                                pricingtype: pricingtype,
                                option: 20, 
                            },
                        }).then(function successCallback(deletePricing) { 
                            //console.log(deletePricing.data);

                            if(deletePricing.data == "done"){
                                $scope.selectItem(prim);
                            }
                               
                        }, function errorCallback(deletePricing) {
                            alert("Error deleting this Both Currency");
                    });   
                     
                }

            }
            $scope.changePricingType = function(pricingtype){
                $scope.removeBtnPricing = true;
            }

            $scope.cancelNewPricing = function(prim){
                if (confirm("Are you sure you want to cancel new pricing? Cancelling this will ignore all your changes")) { 
                    $scope.selectItem(prim);
                }
            }

            $scope.sortableOptions = function(){
                console.log("Yes moving");
            }

             $scope.CheckEmpty = function(obj) {
                    for(var prop in obj) {
                        if(obj.hasOwnProperty(prop)) {
                        return false;
                        }
                    } 
                    return JSON.stringify(obj) === JSON.stringify({});
            }
               

            /************ UPGRADE CMS **************/





            $scope.removePricing = function(id, prim){
                if (confirm("Are you sure you want to delete  this pricing?")) { 
                  //console.log(id + prim);
                        $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {
                                id: id,
                                option: 9, 
                            },
                        }).then(function successCallback(responseDeletePricing) { 
                                $scope.selectItem(prim);
                        }, function errorCallback(responseDeletePricing) {
                            alert("Error retrieving the data");
                        });   
                }
            } 
            
            $scope.countAdditionalDefault = 0;  
            $scope.getPricingAdditionalCost= function(id, evnt){
               
                if(evnt == 'default'){
                        $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {
                                id: id,
                                option: 7, 
                            },
                        }).then(function successCallback(responseAdditional) { 
                            // console.log(responseAdditional.data);  

                             
                             //console.log(responseAdditional.data.length);
                             var priceArr = [];   
                            for (var x = 0; x < $scope.countAdditionalDefault; x++) {    
                                    priceArr.push(x);  
                            }  
                                  
                            $scope.additionalLoops = responseAdditional.data;

                        }, function errorCallback(responseAdd) {
                            alert("Error retrieving the data");
                        });
                }
                
            }
            
            $scope.hereFin = [];
            $scope.getPricingAdditionalCount= function(id, evnt, priceID, arraysInput){
                var id = id || null;
                var evnt = evnt || null;
                var priceID = priceID || null;
                var arraysInput = arraysInput || null;
                //console.log("Eto yung GET COUNT PRICING " + id);
                if(evnt == 'default'){
                        $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {
                                id: id,
                                option: 8, 
                            },
                        }).then(function successCallback(responseAdditionalCount) { 
                             //console.log(responseAdditionalCount.data);   
                             $scope.additionalCounts = responseAdditionalCount.data;
                             //console.log($scope.additionalCounts.value);
                             for(var i in responseAdditionalCount.data){ 
                                //console.log(responseAdditionalCount.data[i]); //alerts key's value
                                var cFin = responseAdditionalCount.data[i] + 1;
                                var priceArrC = [];   
                                for (var x = 1; x < cFin; x++) {    
                                        priceArrC.push(x);  
                                }  
                                $scope['hereFin'][i] = priceArrC;
                            }
                              
                        }, function errorCallback(responseAdditionalCount) {
                            alert("Error retrieving the data");
                        });
                }
                if(evnt == 'add'){ 
                    //console.log("Add mo to " + id + priceID );
                    //console.log(arraysInput); 

                    if(arraysInput == 0 || arraysInput == null){
                        var arraysInput = [];
                    }

                    if(arraysInput.length <= 12){
                        //var addOne = parseInt(arraysInput.length) + 1; 
                        if(arraysInput.length > 0){
                            var addOne = arraysInput[Object.keys(arraysInput)[Object.keys(arraysInput).length - 1]]
                            var plusOne = addOne + 1; 
                            //console.log("Add one"); 
                        }else{
                            var plusOne = parseInt(arraysInput.length) + 1; 
                            //console.log("Normal"); 
                        }
                       
                        arraysInput.push(plusOne);   
                        $scope['hereFin'][id] = arraysInput;
                        //console.log(arraysInput); 
                         
                    }else{
                        alert("Note: Only 12 additional costs are allowed!");
                    }
                   
                }

                if(evnt == 'minus'){ 
                    //var index = arrayColours.indexOf(colour); 
                    //arrayColours.splice(index, 1);
                    //console.log("Minus " + id  + priceID); 
                   for(var i = arraysInput.length - 1; i >= 0; i--) { 
                        if(arraysInput[i] == id) {
                            arraysInput.splice(i, 1);  
                            //console.log(arraysInput);    
                        }
                    }
                   

                }
            }
            

            $scope.getPricingPushData= function(coun, evnt){
                console.log(coun + evnt);
            }


            $scope.sendAlert = function(){
                alert("Please select   Pricing Type!");
            }

            $scope.checkNumber = function(text){ 
                      /*  var transformedInput = text.replace(/[^0-9-.]/g, '');
                        if (transformedInput !== text) {
                            alert("Not a number");
                        } */
            }





        //Preview Table
        $scope.previewTable = function(size1, size2, size3, size4 ){
                        var th = '<th class="text-center"> No sizing data </th>'; 
                        var td1= ''; 
                        var th3= ''; 
                        var td4= '';  
                        //Sizing 1
                        if(size1){
                            var size1Array = size1.split(',');
                            //SIze1
                            if(size1Array.length > 0){
                                th = '<tr>';
                                for(var tx = 0; tx <= size1Array.length; tx++ ){
                                    if(typeof size1Array[tx] === 'undefined'){
                                        false;
                                    }else{
                                        th  += '<th>' + size1Array[tx] + '</th>';
                                    } 
                                }
                                th += '</tr>'; 
                            }
                        }
                        //Sizing 2
                        if(size2){
                            var size2Array = size2.split(',');
                            if(size2Array.length > 0){ 
                                //SIze2
                                td1 = '<tr>';
                                for(var tx1 = 0; tx1 <= size2Array.length; tx1++ ){
                                    if(typeof size2Array[tx1] === 'undefined'){
                                    false;
                                    }else{
                                        td1  += '<td>' + size2Array[tx1] + '</td>';
                                    } 
                                }
                                td1 += '<tr>';
                            }
                        }

                        //Sizing 3
                        if(size3){
                            var size3Array = size3.split(',');
                            if(size3Array.length > 0){
                                th3 = '<tr>';
                                for(var tx3 = 0; tx3 <= size3Array.length; tx3++ ){
                                    if(typeof size3Array[tx3] === 'undefined'){
                                        false;
                                    }else{
                                        th3  += '<th>' + size3Array[tx3] + '</th>';
                                    } 
                                }
                                th3 += '</tr>';
                            
                            }
                        }

                        //Sizing 4
                        if(size4){
                                var size4Array = size4.split(',');
                                if(size4Array.length > 0){
                            
                                    td4 = '<tr>';
                                    for(var tx4 = 0; tx4 <= size4Array.length; tx4++ ){
                                        if(typeof size2Array[tx4] === 'undefined'){
                                            false;
                                        }else{
                                            td4  += '<td>' + size4Array[tx4] + '</td>';
                                        } 
                                    }
                                    td4 += '<tr>';
                                } 
                        } 
                        $scope.PreviewTableResult =  '<table class="table table-bordered  tableSizer margin-top"> ' + th + td1 +  th3 + td4 +' </table>';
        }
        //Preview Table 


  
        //Discard changes 
        $scope.discardTrack = function(userID){ 
        //console.log(userID);
            $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: { 
                                userID: userID,
                                option: 5, 
                            },
                        }).then(function successCallback(responseTrack) { 
                                //console.log(responseTrack.data);   
                        }, function errorCallback(responseTrack) {
                            alert("Error retrieving the data");
            }); 
        }

        $scope.countString = function(stringValue, limitValue){
            var n = stringValue.length;
            if(n >= limitValue){
                alert("No more than " + limitValue);
                return;
            }
            //console.log(stringValue);
        }

        /* Remove images */
        $scope.removeImage = function (Prim, Code, Image){
            console.log(Prim+ " / " + Code + " / " + Image);

            if (confirm("Are you sure you want to delete " + Code + '-' + Image + ".jpg ?")) { 
                $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {
                                Prim: Prim,
                                Image: Image,
                                Code: Code,
                                option: 12, 
                            },
                }).then(function successCallback(responseDel) { 
                    console.log(responseDel.data);
                    if(responseDel.data == 'success'){
                        $scope.selectItem(Prim); 
                                
                                //470 delete CI controller
                                var ImageCodeSend = Code + "/" + Image;
                                var UrlImgController = "/resizerimage/" + ImageCodeSend + "?option=2";;
                                $http({
                                            method: "post",
                                            url:  UrlImgController,
                                            data: {imgCode:$scope.editImageCode}
                                }).then(function successCallback(responseImg) {   
                                            console.log("Removed to " + responseImg.data);  
                                }, function errorCallback(response) {
                                            alert(response + " Error creating 470 images");
                                });  
                    }

                }, function errorCallback(responseDel) {
                    alert("Error retrieving the data");
                }); 
            }     

        }




        /* Stock and colours changes for image */
        
        $scope.stockcolourChange = function(colour, imgNum, code, primId){
            //console.log(colour + '-' + imgNum + '-' + code); 
                $http({
                        method: "post",
                        url:  "<?php echo $angularPost; ?>",
                        data: {
                            colour: colour,
                            imgNum: imgNum,
                            code: code,
                            option: 13, 
                        },
                }).then(function successCallback(response) { 
                    //console.log(response.data);
                    /*var element = angular.element('#successModal'); 
                        element.modal('show'); 
                        $scope.successMsg = 'Stock saved!'; */
                    var elementStock = angular.element('.allStockModel'); 
                        elementStock.modal('hide');

                    /* NEw colour */
                    var elementR = angular.element('.colourBox' + imgNum  + ' span' ); 
                    elementR.remove();   

                    if(colour != null){
                        var elementX = angular.element('.colourBox' + imgNum ); 
                        var svg = angular.element('<span><strong>' + colour + '</strong></span>'); 
                        elementX.append(svg);
                    }
                    

                    /* NEw colour */
                        
                       /* $timeout(function() {
                                    element.modal('hide'); 
                                    $scope.selectItem(primId); 
                        }, 900); */
                }, function errorCallback(response) {
                    console.log("Error retrieving the colour data" + response.data);
                }); 
        }  

        $scope.stockcodeChange = function(stock, imgNum, code, primId, partName, comCode){
            //console.log(stock + '-' + imgNum + '-' + code);
            var partName = partName || null;
            var comCode = comCode || null;

            $http({
                    method: "post",
                    url:  "<?php echo $angularPost; ?>",
                    data: {
                        stock: stock,
                        imgNum: imgNum,
                        code: code,
                        option: 14, 
                    },
            }).then(function successCallback(response) { 
                //console.log(response.data);
                /* var element = angular.element('#successModal'); 
                    element.modal('show'); 
               
                    $scope.successMsg = 'Stock saved!'; */

                    var elementStock = angular.element('.allStockModel'); 
                    elementStock.modal('hide');

                    /* NEw image */
                    var elementR = angular.element('.stockCodeBox' + imgNum  + ' span' ); 
                    elementR.remove();   

                    if(stock != null){
                        var elementX = angular.element('.stockCodeBox' + imgNum ); 
                        var svg = angular.element('<span><strong>' + partName + ' - ' + comCode + '</strong></span>'); 
                        elementX.append(svg);
                    }
                    

                     /* NEw image */

                    /* $timeout(function() {
                                element.modal('hide'); 
                                //$scope.selectItem(primId); 
                    }, 900); */
            }, function errorCallback(response) {
                console.log("Error retrieving the stock code data" + response.data);
            }); 
        }     

        $scope.saving = null; 
        var _timeout;
        $scope.captionUpdate = function(code, caption,  imgNum){
           // console.log(code + "/ " + caption + "/ " + imgNum);
            $scope.saving = imgNum; 

             if(_timeout) { // if there is already a timeout in process cancel it
                $timeout.cancel(_timeout);
            }
            _timeout = $timeout(function() {
                 
                $http({
                    method: "post",
                    url:  "<?php echo $angularPost; ?>",
                    data: {
                        imgNum: imgNum,
                        caption: caption,
                        code: code,
                        option: 18, 
                    },
                }).then(function successCallback(response) { 
                        //console.log(response.data); 
                        $timeout(function() {
                                $scope.saving = null; 
                        }, 900);
                
                    }, function errorCallback(response) {
                    console.log("Error retrieving the caption" + response.data);
                }); 
                  
                 
                _timeout = null;
            }, 1500);



               

        }

        /* Stock and colours changes for image */


        /* Add new product */
        $scope.existsMsg= false;
        $scope.checkCode = function(codecheck){
            console.log(codecheck);
            $http({
                    method: "post",
                    url:  "<?php echo $angularPost; ?>",
                    data: { 
                        codecheck: codecheck, 
                        option: 15 
                    },
            }).then(function successCallback(response) { 
                console.log(response.data);
                if(response.data == "1"){
                    $scope.existsMsg= "Warning: Code already exist!"; 
                }else{
                    $scope.existsMsg= false; 
                }
               
            }, function errorCallback(response) {
                alert("Error retrieving the data" + response.data);
            }); 
        } 

        $scope.addNewProduct = function(codeProduct, nameProduct, NewPricingType){
            //console.log(codeProduct + " == "+ nameProduct + " == " + NewPricingType);
             $http({
                    method: "post",
                    url:  "<?php echo $angularPost; ?>",
                    data: { 
                        codeProduct: codeProduct, 
                        nameProduct: nameProduct, 
                        NewPricingType: NewPricingType,
                        option: 16 
                    },
            }).then(function successCallback(response) { 
                //console.log(response.data);
                $scope.NewCode = "";
                $scope.NewName = "";
                $scope.NewPricingType = "";

                //$window.location.reload();    
                
                $scope.selectItem(response.data); 
             
                var element = angular.element('#newProductModal');  
                    $timeout(function() {
                                element.modal('hide');  
                    }, 900);  
               
            }, function errorCallback(response) {
                alert("Error retrieving the data" + response.data);
            }); 
        }

        
        $scope.overWrite = function(overwriteCode, overwritePrim){ 
            if (confirm("Are you sure you want to overwrite the user?")) {  
                    $http({
                        method: "post",
                        url:  "<?php echo $angularPost; ?>",
                        data: {
                            overwriteCode: overwriteCode,
                            overwritePrim: overwritePrim,
                            option: 17, 
                        },
                    }).then(function successCallback(responseDeleteTracker) { 
                            //console.log(responseDeleteTracker.data);
                            //Refresh with the item selected
                            $scope.selectItem(responseDeleteTracker.data); 
                    }, function errorCallback(responseDeleteTracker) {
                            alert("Error retrieving the overwriteCode");
                    });   
            }
        }

        $scope.clearTableBG = function(){
            var element = angular.element('.productstr'); 
            element.css('background-color', 'transparent');  
        }

        $scope.checkThisForm = function(opts, val){
             
            if(val){
                        $scope.newSearchValue = $scope.searchCleanString(val);
                        var element; 
                        if(opts == 'Name'){
                            element = angular.element('.editNameProducts');
                        }
                        if(opts == 'newName'){
                            element = angular.element('.newName');
                        }
                        if(opts == 'Description'){
                            element = angular.element('.descriptionproducts');
                        }
                         
                        element.val($scope.newSearchValue);   
                        console.log($scope.newSearchValue); 
            }
        }

        $scope.searchCleanString = function(string){
        
            var str = string.replace(/&amp;|&amp/gi, '');
                str = str.replace("&#039;", "'");
                str = str.replace("â€”", "");
                str = str.replace("â€™", "");
                str = str.replace("â€“", "");
                str = str.replace("â€¢", "");
                str = str.replace("Â", "");
                 
            return str.replace(/[&;@!^$~:*?<>{}]/g, '');

        } 

        $scope.cleanString = function(string){
            var strFinal = null;
            if(string){
                var str = string.replace(/&amp;|&amp/gi, '&');
                str = str.replace("&#039;", "'");
                strFinal =  str.replace(/[\\\;$~:*?<>{}]/g, '');
            }
            
            return strFinal;
           

        } 

        /* Change log NEW */

        $scope.addToChangeLog = function(ind, code, currency, modelTxt, priceType ){

           // console.log(modelTxt);
            //console.log(ind +  " / " + code + " / " + currency  );

            if(modelTxt == true){

                 $scope.checkBoxesChangeLog = {};

                 $http({
                        method: "post",
                        url:  "<?php echo $angularPost; ?>",
                        data: {
                            ind: ind,
                            code: code,
                            currency: currency,
                            option: 24
                        },
                    }).then(function successCallback(response) { 
                            // console.log(response.data); 
                            // console.log($scope.LoopFinalChangeLog);
                            // console.log($scope.countChangeLog);

                             var typ = null;   
                             switch (currency){
                                 case "NZD":
                                    typ = "1";
                                 break;
                                 case "AUD":
                                    typ = "7";
                                    break;
                                 case "SGD":
                                    typ = "13";
                                    break;
                                 case "MYR":
                                    typ = "14";
                                    break;
                                 default:      
                             }

                             var pricing = response.data;  

                             var price1 = "";
                             var price2 = "";
                             var price3 = "";
                             var price4 = "";
                             var price5 = "";
                             var price6 = "";

                             
                             var pricingDesc = priceType + " - " + pricing.Price1 + ", " + pricing.Price2 + ", " +  pricing.Price3 + ", " + pricing.Price4 + ", " + pricing.Price5 + ", " + pricing.Price6; 
                              

                             

                            $scope.checkBoxesChangeLog  = { 
                                    "pricing":  pricingDesc,
                                    "countRow" : $scope.countRowLog,
                                    "type" : typ,
                                    "place" : ind
                            }


                             
                            $scope.changeLogLooping();
                              

                             $scope.countRowLog++;

                             //$scope.changeLogLooping(true);
                             
                            
                    }, function errorCallback(response) {
                            alert("Error retrieving the price!");
                });   

            }else{
                $scope.changeLogLooping('remove', 1, ind);
            }

           


        }

        $scope.pushChangeLog = function(log){
            $scope.editForms.changeLogUpdate = log;
            
        }

        $scope.changeLogLooping = function(click, ind, values){
            var click = click || null;
            var ind = ind || 0;
            var values = values || null;
           
           // console.log("Click = " + click);

            $scope.LoopFinalChangeLog = {}; 

            if(click == null){

                     
                    if($scope.countChangeLog == 1 && $scope.checkBoxesChangeLog.type != null){ 
                        click = true;   
                        $scope.editForms.changeLogUpdate[0]  = {"changeLogType": $scope.checkBoxesChangeLog.type, "changeLogDescription":  $scope.checkBoxesChangeLog.pricing, "changeLogPlace" : $scope.checkBoxesChangeLog.place}; 
                    }
                    if($scope.countChangeLog > 1 && $scope.checkBoxesChangeLog.type != null){ 
                        click = true;   
                        var countNew = $scope.countChangeLog - 1;
                        $scope.editForms.changeLogUpdate[countNew]  =   {"changeLogType": $scope.checkBoxesChangeLog.type, "changeLogDescription":  $scope.checkBoxesChangeLog.pricing, "changeLogPlace" : $scope.checkBoxesChangeLog.place}; 
                        
                    }  


            }

            
            //console.log($scope.editForms.changeLogUpdate);
           // console.log("$scope.countChangeLog " + $scope.countChangeLog);
            
           //Ovewrite
            if(click == 'remove' && $scope.countChangeLog == 1){   
                //console.log("Dito na tayo!");
                $scope.editForms.changeLogUpdate  = { }; 
            }
                
            if(click == true){   
                //console.log("HALA PASOK");
                $scope.editForms.changeLogUpdate[$scope.countChangeLog] = $scope.filterChangeLog($scope.editForms.changeLogUpdate);   
                $scope.countChangeLog++;   
                
            }
            if(click == 'remove' && $scope.countChangeLog > 1){   
                //console.log("OOOOH PASOK");
                //Remove From checkbox
                if(ind == 1 && values){
                    //console.log("Removed from checkbox");
                    //console.log($scope.editForms.changeLogUpdate);
                    //console.log($scope.countChangeLog);
                    //console.log("values " + values);
                    var remCount = null;
                    for(var cl = 0; cl < $scope.countChangeLog; cl++){
                        if($scope.editForms.changeLogUpdate[cl].changeLogPlace == values ){
                            remCount = cl;
                            //console.log($scope.editForms.changeLogUpdate[cl].changeLogType + " ==> " + $scope.editForms.changeLogUpdate[cl].changeLogPlace );

                            delete $scope.editForms.changeLogUpdate[cl]; 
                            break;    
                           
                        } 
                    }

                  //console.log("remCount = " + remCount); 
                }
                //console.log($scope.editForms.changeLogUpdate);
                

                $scope.editForms.changeLogUpdate[$scope.countChangeLog] = $scope.filterChangeLog($scope.editForms.changeLogUpdate); 

                $scope.countChangeLog--;   
                var countL = $scope.editForms.changeLogUpdate.length - 1;
                
                var strArrRem = {};
                for(var rm = 0; rm < countL; rm++){ 
                    strArrRem[rm] = $scope.editForms.changeLogUpdate[rm];
                } 
                $scope.editForms.changeLogUpdate[$scope.countChangeLog] = strArrRem;
                 
            }

           
            
            

              if(click == 'refresh'){   
                    //Force to 1
                    $scope.countChangeLog = 1;
              }
           
           // console.log("$scope.countChangeLog => " + $scope.countChangeLog);    
            //Set the values   
            for(var lx=0; lx < $scope.countChangeLog; lx++){ 
               // console.log(" GETXX => " + lx);
                $scope.LoopFinalChangeLog[lx]  = lx;   
               
            }

            $scope.getLoopCount = $scope.countChangeLog - 1;

           
        }

        $scope.alertThis = function(){
            alert("Please select Change Type!");
        }

        

        $scope.filterChangeLog = function(changeLogs){
            var strArrs = {};
            for(var x = 0; x < changeLogs.length; x++){
                if(changeLogs[x].changeLogType){
                    strArrs[x] = changeLogs[x];
                } 
            } 
            return strArrs;
        }

        $scope.changeLogLoopingNew = function(click, stat, index){
            console.log("Index " + index);
            console.log("Stat " + stat);
            console.log( "click " + click);

           
            if(stat == true){
                $scope.countChangeLog++;
            }else{
                $scope.countChangeLog--;
            }
              
             
            $scope.LoopFinalChangeLog = []; 
            for(var lx=0; lx < $scope.countChangeLog; lx++){ 
                $scope.LoopFinalChangeLog[lx]  = lx;  
                
                
            }
            
        }


 

}]); // end controller

 

tgpApp.filter("trust", ['$sce', function($sce) {
  return function(htmlCode){
    return $sce.trustAsHtml(htmlCode);
  }
}]);
  
 
 
</script>

