<?php

    $sql= getProducts($table); 
   
    $json_data=array();
    foreach($sql as $rec)//foreach loop  
    {  
      $json_array['Prim']=$rec['Prim']; 
      $json_array['Code']=$rec['Code'];  
      $json_array['Name']=clean($rec['Name']); 
      if($rec['Active'] == 1){
          $Active = 'Active';
      }else{
         $Active = 'Inactive';
      }
      $json_array['Active'] = $Active;
      array_push($json_data,$json_array);
    } 
    $my_edit = json_encode($json_data,JSON_PRETTY_PRINT); 
     
    function clean($string) { 
        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
   }
?>

<script>
// Define the `phonecatApp` module 
 
tgpApp.controller("editCtrl",function($scope, $http, $httpParamSerializerJQLike, $timeout){
    
    $scope.formForwardTable = {}; 
    $scope.selectTable = {'productsCurrentDEV':"productsCurrentDEV", 'productsCurrent':"productsCurrent" };
    $scope.selectTableDuplicate =  'productsCurrentDEV';
    //$scope.formForwardTable.selectTableForward = $scope.selectTable['0'];

    $scope.formForwardTableSubmitted = function(){
        $scope.formForwardTable.option = 1;
        if (confirm("Are you sure you want to move these items to another table?")) { 
            $http({
                method: "post",
                url:  "<?php echo $angularPost; ?>",
                data: $scope.formForwardTable  
            }).then(function successCallback(good) {
                console.log(good.data);
                
                $scope.formForwardTable.selectTableForward = '';

                var element = angular.element('#successModal'); 
                element.modal('show'); 
                $scope.successMsg = 'Done and transfered data to another table!';
                $timeout(function() {
                    element.modal('hide'); 
                }, 900);
            }, function errorCallback(response) {
                alert("Error inserting the data");
            }); 
        }
    }
    
    $scope.duplicates= '';
    $scope.checkDuplicated = function(table){
           //console.log(table);
            $http({
                method: "post",
                url:  "<?php echo $angularPost; ?>",
                data: {table:table, option: 2 }  
            }).then(function successCallback(dups) {
                //console.log(dups.data);
                $scope.duplicatesTable = table; 
                if(dups.data != 0){
                    $scope.duplicatesCode = dups.data; 
                }else{
                    $scope.duplicatesCode = [{"Code": "0 - no duplicates"}]
                } 
                    var element = angular.element('#duplicatesModal'); 
                    element.modal('show');  
                
                 
            }, function errorCallback(response) {
                alert("Error inserting the data");
            });  
    }

}); // end controller



 
 
</script>

