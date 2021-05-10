<?php
 
    $sql= getProducts($table); 
    
    $json_data=array();
    foreach($sql as $rec)//foreach loop  
    {  
      $json_array['Prim']=$rec['Prim']; 
      $json_array['Code']=$rec['Code'];   
      $json_array['Name']= html_entity_decode($rec['Name'], ENT_QUOTES);
      $json_array['OnDemandStock']=$rec['OnDemandStock'];   
      array_push($json_data,$json_array);
    } 
    $my_edit = json_encode($json_data,JSON_PRETTY_PRINT); 
     
    
    
    

    function clean($string) { 
        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
   }
?>

<script>
// Define the `phonecatApp` module 
 
//tgpApp.controller("editCtrl",function($scope, $http, $httpParamSerializerJQLike, $timeout, Upload,   $sce){

tgpApp.controller("editCtrl",  ['$scope', '$http', '$httpParamSerializerJQLike',  'Upload', '$timeout', '$sce',  function($scope, $http, $httpParamSerializerJQLike, Upload, $timeout, $sce){  

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.products = <?php echo $my_edit; ?>;
  
  $scope.showNone = 0;
  $scope.editStocks = {}
  $scope.editStocks.StocksLists = 0; 

  $scope.selectItemNew = function(models){
     var newModels = models.split(' / ');
     console.log(newModels[0]);
     var primID, code, name;  
  }

//OLD $scope.selectItem = function(primID, code, name){
  $scope.selectItem = function(models){
    
    
    var newModels = models.split(' / ');
    //console.log(newModels[0]);
    var primID, code, name;  

    primID = newModels[0];
    code = newModels[1];
    name = newModels[2];

                $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: {code: code, option: 1}
                }).then(function successCallback(stocks) { 
                           //console.log(stocks.data); 

                           $scope.showNone = 1;

                           $scope.btnName = name;
                           $scope.btnCode = code;
                           $scope.btnPrim = primID;

                           if(stocks.data != '0'){
                                $scope.editStocks.StocksLists = stocks.data;
                           }else{
                                $scope.editStocks.StocksLists = 0;
                           }
                           
                            
                }, function errorCallback(response) {
                            alert(response + " Error getting stock datas");
                });  


  }

  $scope.updateStocks = function(){
      //console.log("Submitted!");
      
       
       $scope.editStocks['option'] = 2;
       //console.log($scope.editStocks);
       
       $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: $scope.editStocks
                }).then(function successCallback(response) { 
                           console.log(response.data);   
                           if(response.data == '1'  ){ 
                                var element = angular.element('#successModal'); 
                                element.modal('show'); 
                                $scope.successMsg = "All good!";

                                $timeout(function() { 
                                    element.modal('hide'); 
                                }, 2000);
                           }
                            
                }, function errorCallback(response) {
                            alert(response + " Error saving stock datas");
        });  

  }

  $scope.deleteStock = function(btnPrim, btnName, code, rm){
        
        if(confirm("Clear and remove this On Demand Stock?") == true ){
            
            //console.log(btnPrim + "/" + btnName + "/" + code+ "/" + rm); 
            $http({
                            method: "post",
                            url:  "<?php echo $angularPost; ?>",
                            data: { code: code, rm: rm, option: 3}
                }).then(function successCallback(response) { 
                           //console.log(response.data);   
                           if(response.data == '1'  ){ 
                                $scope.selectItem(btnPrim, code, btnName);
                           }
                }, function errorCallback(response) {
                            alert(response + " Error saving stock datas");
            }); 
        }
        
  }
  

}]); // end controller

 

tgpApp.filter("trust", ['$sce', function($sce) {
  return function(htmlCode){
    return $sce.trustAsHtml(htmlCode);
  }
}]);
 
</script>

