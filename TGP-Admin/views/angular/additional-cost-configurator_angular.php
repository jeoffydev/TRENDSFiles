
<?php

 //$getThis = getComponentAPI('100109');
 //print_r($getThis->ComponentsResult->Components->Component);
 
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
$products = json_encode($json_data,JSON_PRETTY_PRINT); 
 

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
 
?>

<script>
// Define the `phonecatApp` module

 
 tgpApp.controller("editCtrl",function($scope, $http, $window, $timeout){

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.products = <?php echo $products; ?>;
  $scope.itemNameDisplay = "";
  $scope.foundItems = 0;
  $scope.formUpdateData = {}
  $scope.jsonAdditionals = <?php echo $json_additionalOptions; ?>;
  $scope.formUpdateData.PriceType =  $scope.jsonAdditionals[0].jsonArrays.PriceType[0];
  $scope.formUpdateData.additionalOptionCategory  =  $scope.jsonAdditionals[0].jsonArrays.additionalOptionCategory[0];
  $scope.formDisabled = true;
  $scope.formEditActive = false;
  $scope.successOrder = false;
  

    //Default values
  $scope.formUpdateData.BrandingOption = ""; 
  $scope.formUpdateData.PrizingNZD = "";
  $scope.formUpdateData.PrizingAUD = "";
  $scope.formUpdateData.order == "";
  $scope.formUpdateData.brandingMethodUpdate = "";
  $scope.formUpdateData.brandingAreaUpdate = "";
  $scope.formUpdateData.maxPerUnit = "";
  $scope.BrandingOptionsList = false;
  $scope.thispricingNZD = false;
  $scope.thispricingAUD = false;
  $scope.converted = 0;
  $scope.generalConverted = 0;
   

 //console.log( $scope.jsonAdditionals[0].jsonArrays.additionalOptionCategory[0]);
  $scope.selectItem = function(val){
      var element = angular.element('.additional-config-searchbox'); 
      if(val.length > 3){ 
          element.css('display', 'block');  
      }else{
        element.css('display', 'none');   
        $scope.formReset();
      } 
  }

  $scope.formReset = function(){
        $scope.dataItems = false;
        $scope.formUpdateData = {}
        $scope.formUpdateData.PriceType =  $scope.jsonAdditionals[0].jsonArrays.PriceType[0];
        $scope.formDisabled = true;
        $scope.formEditActive = false;
        $scope.foundItems = 0;
        $scope.formUpdateData.brandingMethodUpdate = "";
        $scope.formUpdateData.brandingAreaUpdate = "";
        $scope.BrandingOptionsList = false;
        $scope.thispricingNZD = false;
        $scope.thispricingAUD = false;
        $scope.converted = 0;
        $scope.generalConverted = 0;
  }

  $scope.getThisItem = function(id, code, name ){
     $scope.formReset();
     $scope.closeSearchBox(); 
     
     $scope.formUpdateData.itemCode = code;
     $scope.formUpdateData.itemId = id;
     $scope.formUpdateData.itemName = name;

     $scope.itemNameDisplay = code + " - " + name;
     //console.log($scope.formUpdateData);

    
    
     $scope.getTheMax(code);
     
     $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  {code: code, id: id,  option: 1}  
                                }).then(function successCallback(response) {
                                     console.log(response.data);  
                                     //console.log(response.data.found)

                                     console.log(response.data.componentAPI.ComponentsResult.Components.Component);  
                                     
                                     $scope.componentsAPI = response.data.componentAPI.ComponentsResult.Components.Component;

                                     $scope.foundItems = response.data.found;

                                     //Branding 
                                     $scope.BrandingOptionsList = response.data.brandingOptions;

                                     $scope.pricingTypeList = response.data.pricingTypeList;

                                      $scope.formUpdateData.PriceType = "";

                                    /*
                                     if($scope.foundItems == 1){
                                        $scope.itemName = code + " - " + name;
                                        $scope.dataItems = response.data.dataItems;
                                     } */
                                    
                                }, function errorCallback(response) {
                                    alert("Error retreiving data");
      });         
     
  }

  $scope.selectAnother = function(PriceType, itemCode){

        //console.log(PriceType + "/" + itemCode);
 

        $scope.formDisabled = true;
        $scope.thispricingNZD = false;
        $scope.thispricingAUD = false;
        $scope.formUpdateData.brandingMethod = "";
        $scope.formUpdateData.brandingArea = "";
        $scope.formUpdateData.additionalOptionCategory = "";
        $scope.formUpdateData.BrandingOption =""; 
        $scope.converted = 0;
        $scope.generalConverted = 0;

         $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  {itemCode: itemCode, PriceType: PriceType,  option: 8}  
                                }).then(function successCallback(response) {
                                       console.log(response.data);  
                                      
                                      $scope.getTheMax(itemCode, PriceType);

                                      $scope.dataItems = response.data.dataItems;

                                      $scope.converted = response.data.ConvertedRow;

                                       
                                      
                                        
                                       
 
                                    
                                    
                                }, function errorCallback(response) {
                                    alert("Error getting the Additonal costs temp datas");
        });         


       
  }

  $scope.checkIfExist = function(code, pricetype, brand=null){
       //console.log(code + " / " + pricetype + "/" + brand);
       if(pricetype == "--Select--"){
            $scope.getThisItem($scope.formUpdateData.itemId, code, $scope.formUpdateData.itemName);
            return;
       }
      if(code && pricetype){

          

          $http({
                                      method: "post",
                                      url:  "<?php echo $angularPost; ?>",
                                      data:  {code: code, pricetype: pricetype, brand: brand,  option: 2}  
                                  }).then(function successCallback(response) {
                                      console.log(response.data);  
                                     /* if(response.data.Exist == 1){

                                        //Reset each
                                        $scope.formDisabled = true;
                                        $scope.thispricingNZD = false;
                                        $scope.thispricingAUD = false;
                                        $scope.formUpdateData.brandingMethod = "";
                                        $scope.formUpdateData.brandingArea = "";
                                        $scope.formUpdateData.additionalOptionCategory = "";

                                        alert("This item and Pricing Type is already exist in AddtionalTemp table!") 
                                        return;
                                      }else{  */
                                        $scope.formDisabled = false;
                                        //Get the default after form was disabled
                                        $scope.formUpdateData.additionalOptionCategory  =  $scope.jsonAdditionals[0].jsonArrays.additionalOptionCategory[0];
                                        $scope.thispricingNZD = response.data.AdditionalPricingNZD;
                                        $scope.thispricingAUD = response.data.AdditionalPricingAUD;
                                     // } 
                                      
                                  }, function errorCallback(response) {
                                      alert("Error retreiving data");
          });      

      } 

      //$scope.formDisabled = false;
  }

 

  $scope.closeSearchBox = function(){
      var element = angular.element('.additional-config-searchbox'); 
      element.css('display', 'none');  
  }

  $scope.notificationUpdateData = function(){

      console.log($scope.formUpdateData); 

        if($scope.formUpdateData.additionalCostID){
            alert("YES UPDATE HERE");
            $scope.formUpdateData.option = 5;
            $http({
                                        method: "post",
                                        url:  "<?php echo $angularPost; ?>",
                                        data:  $scope.formUpdateData 
                                    }).then(function successCallback(response) {
                                        console.log(response.data);  
                                         
                                        
                                    }, function errorCallback(response) {
                                        alert("Error updating data");
            });  

             return;
        }
    
        if($scope.formUpdateData.BrandingOption == null || $scope.formUpdateData.BrandingOption ==""){
            alert("Branding Option is required!");
            return;
        }
        if($scope.formUpdateData.additionalOptionCategory == "--Select--"){
            alert("Type is required!");
            return;
        }

        if( ($scope.formUpdateData.PrizingNZD  == null || $scope.formUpdateData.PrizingNZD  == "") &&  ($scope.formUpdateData.PrizingAUD  == null || $scope.formUpdateData.PrizingAUD  == "") ){
            alert("Pricing NZD or AUD required!");
            return;
        }

        /* if($scope.formUpdateData.order == null || $scope.formUpdateData.order ==""){
            alert("Order is required!");
            return;
        }  */
        console.log($scope.formUpdateData); 

       /* if($scope.formUpdateData.componentPricePerUnitItemCode == "" || $scope.formUpdateData.componentPricePerUnitItemCode == null){
            alert("Price per Unit Charge Code is required!");
            return;
        } 

        if($scope.formUpdateData.pricePerOrderCode == "" || $scope.formUpdateData.pricePerOrderCode == null){
            alert("Price per Order Charge Code is required!");
            return;
        }*/

        $scope.formUpdateData.pricePerUnitItemCode = $scope.formUpdateData.componentPricePerUnitItemCode; 
        $scope.formUpdateData.pricePerOrderCode = $scope.formUpdateData.pricePerOrderCode;
        
        $scope.formUpdateData.option = 3;
        $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  $scope.formUpdateData 
                                }).then(function successCallback(response) {
                                     console.log(response.data);  


                                     $scope.getThisItem($scope.formUpdateData.itemId, $scope.formUpdateData.itemCode, $scope.formUpdateData.itemName);
                                    // $window.location.reload();
                                    
                                }, function errorCallback(response) {
                                    alert("Error saving data");
        });         


  }

  $scope.checkInteger = function(val){
        if(val % 1 !== 0){
            alert("Only numbers are allowed");
            $scope.formUpdateData.maxPerUnit = "";
        }
   
  }

  $scope.getTheMax = function(code, pricetype){

    var pricetype = pricetype || null;

        $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  { option: 4, code: code, pricetype: pricetype}
                                }).then(function successCallback(response) {
                                     
                                     var num = 1;
                                     if(response.data == "none"){ 
                                        $scope.formUpdateData.order = num;  
                                     }
                                     if(response.data  ==  0 || response.data > 0){
                                         num = response.data;
                                         num++; 
                                         $scope.formUpdateData.order = num; 
                                     }
                                    
                                }, function errorCallback(response) {
                                    alert("Error retreiving Order");
        });     
  }

  $scope.editAdditionalCost = function(data){
      
    /* reset and loose */

    $scope.formUpdateData.PrizingNZD  = ""; 
    $scope.formUpdateData.PrizingAUD  = ""; 

    console.log("EDIT HERE"); 
      console.log(data); 
      $scope.formEditActive = true;
      $scope.formDisabled = false;

      //Set variable and values
      $scope.formUpdateData.BrandingOption = { "pm": data.brandingMethod, "pa": data.brandingArea}  


      $scope.formUpdateData.additionalCostID = data.additionalCostID; 
      $scope.formUpdateData.PriceType = data.PricingType; 

      $scope.formUpdateData.brandingMethod = data.brandingMethod;
      $scope.formUpdateData.brandingArea  = data.brandingArea;
      
      //NZD
      $scope.formUpdateData.PrizingNZD ={"desc": data.costDescription, "ucost": data.NZDUnitPrice, "setup": data.NZDOrderPrice}; 

      //AUD
      $scope.formUpdateData.PrizingAUD ={"desc": data.costDescription, "ucost": data.NZDUnitPrice, "setup": data.NZDOrderPrice}; 
      
      $scope.formUpdateData.additionalOptionCategory = data.additionalOptionCategory;
      $scope.formUpdateData.costDescription = data.costDescription;

        //The Order increases 1 so need to edit here  ****************************************************************************************
      $scope.formUpdateData.order = Number(data.orderRow);
      $scope.formUpdateData.maxPerUnit = Number(data.maxPerUnit);
      $scope.formUpdateData.pricePerUnitItemCode = Number(data.pricePerUnitItemCode);
      $scope.formUpdateData.pricePerOrderCode = Number(data.pricePerOrderCode);

      console.log($scope.formUpdateData.componentPricePerUnitItemCode + " This one"); 

      //Other Details
        







        
  }

  $scope.updateAdditionalOrder = function() {
     

                                $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  { option: 6, datas: $scope.dataItems}
                                }).then(function successCallback(response) {
                                   // console.log(response.data);  
                                    if(response.data == 1){
                                        $scope.successOrder = true;
                                        $timeout(function() {
                                            $scope.successOrder = false;
                                        }, 500);
                                    }
                                    
                                }, function errorCallback(response) {
                                    alert("Error retreiving Order");
        });     

        
  };


  $scope.conversionCheck = function(data, itemName, additionalcostID){
      
      $scope.popupName = itemName;
      $scope.popupConversion = data;
      $scope.conversionAdditionalcostID = additionalcostID
      //console.log(data);

        $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  { option: 7, data: data}
                                }).then(function successCallback(response) {
                                      
                                    console.log(response.data);

                                    $scope.conversionDatas = response.data;
                                    
                                }, function errorCallback(response) {
                                    alert("Error retreiving Old New Conversion");
        });     


  }

  $scope.conversionCheckNew = function(code, pricingTypeList, name){
      
      
      //console.log(data);

      $scope.popupName = name;

        $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  { option: 11, code: code, pricingTypeList: pricingTypeList}
                                }).then(function successCallback(response) {
                                      
                                    console.log(response.data);

                                    $scope.conversionDatasNew = response.data;
                                    
                                }, function errorCallback(response) {
                                    alert("Error retreiving Old New Conversion");
        });     


  }

  $scope.checkobject = function(data){
    console.log(data);
  }

    $scope.convertToFinalNew = function(code, pricingTypeList, itemid, name){
       
       $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  { option: 12,  code: code, pricingTypeList: pricingTypeList }
                                }).then(function successCallback(response) {
                                      
                                     console.log(response.data);

                                     
                                    if(response.data == "duplicated"){
                                        alert("This item is already converted!"); 
                                        return;
                                    }

                                    if(response.data == "failed"){
                                        alert("Failed to convert!"); 
                                        return;
                                    }
                                    
                                    
                                    if(response.data == "success"){
                                        $scope.getThisItem(itemid, code, name);

                                        var element = angular.element('#convertModal');   
                                        $timeout(function() {
                                            element.modal('hide'); 
                                        }, 900);   
                                    }

                                     

                                    
                                    
                                }, function errorCallback(response) {
                                    alert("Error Final conversion");
        });     

  }

  $scope.convertToFinal = function(id, itemid, code, name, pricingtype){
       
       $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  { option: 9, thisID: id, code: code, pricingtype: pricingtype}
                                }).then(function successCallback(response) {
                                      
                                    //console.log(response.data);

                                    if(response.data == "duplicated"){
                                        alert("This item is already converted!"); 
                                        return;
                                    }

                                    if(response.data == "duplicated"){
                                        alert("Failed to convert!"); 
                                        return;
                                    }

                                    if(response.data == "success"){
                                        $scope.getThisItem(itemid, code, name);

                                        var element = angular.element('#convertModal');   
                                        $timeout(function() {
                                            element.modal('hide'); 
                                        }, 900);   
                                    }

                                    
                                    
                                }, function errorCallback(response) {
                                    alert("Error Final conversion");
        });     

  }

  $scope.removeAdditionalCost = function(id, itemid, code, name, branding=null){
      console.log(id + "/ " + itemid+ "/ " + code+ "/ " + name);
 
      var brand = "";
      if(branding !== null){
         brand = " / " + branding;
      }
        if (confirm("Are you sure you want to delete  this Additional Cost item " + code + "" + brand +  "?")) { 
                  
                        $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data:  { option: 10, thisID: id}
                        }).then(function successCallback(response) { 

                               // console.log(response.data);

                                if(response.data == 'deleted'){
                                    var myId = angular.element( document.querySelector('.deleteThisAdditional' + id) );
                                    myId.addClass('displaynone'); 
                                }

                        }, function errorCallback(response) {
                            alert("Error delete Additional cost");
                        });   
        }
  }


  $scope.cleanString = function(string){
        
        var str = string.replace(/&amp;|&amp/gi, '&');
            str = str.replace("&#039;", "'");
        return str.replace(/[\\\;$~:*?<>{}]/g, '');

  } 


}); // end controller


 
</script>

