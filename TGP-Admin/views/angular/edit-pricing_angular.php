<?php
 
    $sqls= getPricing($table); 
    
    $json_data=array();
    foreach($sqls as $recs)//foreach loop  
    {  
      $json_array['index']=$recs['index']; 
      $json_array['Coode']=$recs['Coode'];  
      $json_array['Naame']=clean($recs['Naame']);  
      $json_array['Currency'] = $recs['Currency'];   
      array_push($json_data,$json_array);
      
    } 
  
    /*  echo "<pre>";
    print_r($json_data);
    echo "</pre>";  */
    
   $my_editprice= json_encode( $json_data,JSON_PRETTY_PRINT);

   function clean($string) { 
        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
   }
  
?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",function($scope, $http, $httpParamSerializerJQLike, $timeout){
    $scope.query = {}
    $scope.queryBy = '$' 
    $scope.pricings = <?php echo  $my_editprice; ?>;
    $scope.orderProp="Coode";  
    
    //Get the Data ID 
    $scope.selectItem = function(id, code, currency) {     

        $http({
            method: "post",
            url:  "<?php echo $angularPost; ?>",
            data: {
                id: id,
                code: code,
                currency: currency,
                option: 1,
                controlName: "<?php  echo $angularControllerFile; ?>",
                modelName: "<?php  echo $angularModelFile; ?>"
            },
        }).then(function successCallback(response) { 
                $scope.Req = "";  
                //console.log(response.data);
                $scope.editPricingForms = response.data;
        }, function errorCallback(response) {
                alert("Error retrieving the data");
        }); 


    }  

     
     $scope.updatePricing = function() {  
                //console.log($scope.editPricingForms); 
                $http({
                        method: "post",
                        url:  "<?php echo $angularPost; ?>",
                        data: $scope.editPricingForms  
                    }).then(function successCallback(good) {
                        
                           //console.log(good.data);  
                            
                         //console.log(good.data.error.Code)  
                        if(good.data.error)
                        { 
                            $scope.errorName = good.data.error.Naame; 
                            $scope.errorCode = good.data.error.Coode; 
                            $scope.errorPriceOrder = good.data.error.PriceOrder;

                             //Quantity
                            $scope.errorQuantity1 = good.data.error.Quantity1;
                            $scope.errorQuantity2 = good.data.error.Quantity2;
                            $scope.errorQuantity3 = good.data.error.Quantity3;
                            $scope.errorQuantity4 = good.data.error.Quantity4;
                            $scope.errorQuantity5 = good.data.error.Quantity5;  
                            $scope.errorPrice1 = good.data.error.Price1;
                            $scope.errorPrice2 = good.data.error.Price2;
                            $scope.errorPrice3 = good.data.error.Price3;
                            $scope.errorPrice4 = good.data.error.Price4;
                            $scope.errorPrice5 = good.data.error.Price5;
                            $scope.errorAdditionalCost1 = good.data.error.AdditionalCost1;
                            $scope.errorAdditionalCost2 = good.data.error.AdditionalCost2;
                            $scope.errorAdditionalCost3 = good.data.error.AdditionalCost3;
                            $scope.errorAdditionalCost4 = good.data.error.AdditionalCost4;
                            $scope.errorAdditionalCost5 = good.data.error.AdditionalCost5;
                            $scope.errorAdditionalCost6 = good.data.error.AdditionalCost6;
                            $scope.errorAdditionalCost7 = good.data.error.AdditionalCost7;
                            $scope.errorAdditionalCost8 = good.data.error.AdditionalCost8;
                            $scope.errorAdditionalCost9 = good.data.error.AdditionalCost9;
                            $scope.errorAdditionalCost10 = good.data.error.AdditionalCost10;
                            $scope.errorAdditionalCost11 = good.data.error.AdditionalCost11;
                            $scope.errorAdditionalCost12 = good.data.error.AdditionalCost12;

                            $scope.errorSetupCharge1 = good.data.error.SetupCharge1;
                            $scope.errorSetupCharge2 = good.data.error.SetupCharge2;
                            $scope.errorSetupCharge3 = good.data.error.SetupCharge3;
                            $scope.errorSetupCharge4 = good.data.error.SetupCharge4;
                            $scope.errorSetupCharge5 = good.data.error.SetupCharge5;
                            $scope.errorSetupCharge6 = good.data.error.SetupCharge6;
                            $scope.errorSetupCharge7 = good.data.error.SetupCharge7;
                            $scope.errorSetupCharge8 = good.data.error.SetupCharge8;
                            $scope.errorSetupCharge9 = good.data.error.SetupCharge9;
                            $scope.errorSetupCharge10 = good.data.error.SetupCharge10;
                            $scope.errorSetupCharge11 = good.data.error.SetupCharge11;
                            $scope.errorSetupCharge12 = good.data.error.SetupCharge12;
                            $scope.icon1 = true;
                            $scope.icon2 = false;
                            $scope.successUpdate = good.data.message;
                        }
                        else
                        { 
                            $scope.errorName = null;
                            $scope.errorCode = null; 
                            $scope.errorPriceOrder = null;
                            $scope.errorQuantity1 = null;
                            $scope.errorQuantity2 = null;
                            $scope.errorQuantity3 = null;
                            $scope.errorQuantity4 = null;
                            $scope.errorQuantity5 = null;
                            $scope.errorPrice1 =  null;
                            $scope.errorPrice2 =  null;
                            $scope.errorPrice3 =  null;
                            $scope.errorPrice4 =  null;
                            $scope.errorPrice5 =  null;
                            $scope.errorAdditionalCost1 =   null;
                            $scope.errorAdditionalCost2 =   null;
                            $scope.errorAdditionalCost3 =   null;
                            $scope.errorAdditionalCost4 =   null;
                            $scope.errorAdditionalCost5 =   null;
                            $scope.errorAdditionalCost6 =   null;
                            $scope.errorAdditionalCost7 =   null;
                            $scope.errorAdditionalCost8 =   null;
                            $scope.errorAdditionalCost9 =   null;
                            $scope.errorAdditionalCost10 =   null;
                            $scope.errorAdditionalCost11 =   null;
                            $scope.errorAdditionalCost12 =   null;

                            $scope.errorSetupCharge1 =    null;
                            $scope.errorSetupCharge2 =    null;
                            $scope.errorSetupCharge3 =    null;
                            $scope.errorSetupCharge4 =    null;
                            $scope.errorSetupCharge5 =    null;
                            $scope.errorSetupCharge6 =    null;
                            $scope.errorSetupCharge7 =    null;
                            $scope.errorSetupCharge8 =    null;
                            $scope.errorSetupCharge9 =    null;
                            $scope.errorSetupCharge10 =    null;
                            $scope.errorSetupCharge11 =    null;
                            $scope.errorSetupCharge12 =    null;


                            $scope.icon1 = false;
                            $scope.icon2 = true;
                            $timeout(function() {
                                $scope.icon2 = false;
                            }, 2000);
                            $scope.successUpdate = good.data.message;
                        }  
                            
                    }, function errorCallback(response) {
                        alert("Error updating the data");
                }); 
   }


     
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

}); // end controller



 
 
</script>

