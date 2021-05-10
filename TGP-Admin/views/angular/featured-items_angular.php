
<?php

$sql= getProducts($table); 
 
$json_data=array();
foreach($sql as $rec)//foreach loop  
{  
  $json_array['Prim']=$rec['Prim']; 
  $json_array['Code']=$rec['Code'];  
  $json_array['Name']=clean($rec['Name']); 
  $json_array['featuredItem']=$rec['featuredItem']; 
  if($rec['Active'] == 1){
      $Active = 'Active';
  }else{
     $Active = 'Inactive';
  }
  $json_array['Active'] = $Active;
  array_push($json_data,$json_array);
} 
$my_products = json_encode($json_data,JSON_PRETTY_PRINT); 


//Get Featured Products
$feauredItems = getFeaturedProducts($table); 
$json_data2=array();
foreach($feauredItems as $rec2)//foreach loop  
{  
  $json_array2['Prim']=$rec2['Prim']; 
  $json_array2['Code']=$rec2['Code'];  
  $json_array2['Name']=clean($rec2['Name']); 
  $json_array2['featuredItem']=$rec2['featuredItem']; 
   
  $json_array2['Active'] = $Active;
  array_push($json_data2,$json_array2);
} 

//$json_data2["Option"] = 2; 
$getFeauredItems = json_encode($json_data2,JSON_PRETTY_PRINT); 


function clean($string) { 
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}
?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",function($scope, $http, $window, $timeout){

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.products = <?php echo $my_products; ?>;
  $scope.featuredItems = <?php echo $getFeauredItems; ?>;
  $scope.originalFeaturedItems = <?php echo $getFeauredItems; ?>;
  $scope.orderProp="Code";  

 
$scope.getItems = function(featuredItems) {   
    $scope.getFeaturedItems = featuredItems;
}    

var arrayItems =[];
var arrayItemsNew =[];
$scope.addedCheck = false;
$scope.selectItem = function(id, code, name, featured) {     
    
    /* $http({
        method: "post",
        url:  "<?php // echo $angularPost; ?>",
        data: {
            id: id,
            code: code,
            name: name,
            featured: featured,
            option: 1, 
        },
    }).then(function successCallback(response) { 
            //console.log(response.data); */
            //console.log($scope.featuredItemsArray); 
            /* var myArray = [];
                myArray['Code'] = code;
                myArray['Name'] = name;
                myArray['featuredItem'] = featured; */
                var myArray = {
                    Prim: id,
                    Code: code,
                    Name: name,
                    featuredItem: featured
                };  
           
           //console.log($scope.getFeaturedItems);
            var length =Object.keys($scope.getFeaturedItems).length;
            //alert(length);
            for (i = 0; i < length; i++) {  
                    console.log($scope.getFeaturedItems[i]['Prim']);  
                    if($scope.getFeaturedItems[i]['Prim'] == id){
                        alert(name + " is already exists");
                        return;
                    }     
            }
           

            var featuredItemsArray =    $scope.getFeaturedItems;
            featuredItemsArray.push(myArray); 
            arrayItemsNew.push(featuredItemsArray);

            $scope.addedCheck = true;
            $timeout(function() {
                $scope.addedCheck = false;
            }, 2000);
            
              //console.log(arrayItems);
            //var myJsonString = JSON.stringify(myArray);
            //var arrayItemsNew2 = JSON.stringify(arrayItemsNew);
            //console.log(arrayItemsNew2);  
           
            //$scope.getFeaturedItems2 = arrayItemsNew2;

           
            /* console.log(response.data);
            $scope.featuredItems = response.data;

            var myArray = {};
                myArray['Code'] = code;
                myArray['Name'] = name;
                myArray['featuredItem'] = featured;
                
            var myJsonString = JSON.stringify(myArray);
            console.log(myJsonString);
            arrayItems.push(myJsonString);
            //console.log(arrayItems);
            $scope.featuredItemsNew = arrayItems;    */

    /* }, function errorCallback(response) {
          alert("Error retrieving the data");
    }); */
 

}  
$scope.updateFeatured = function() {  
                //console.log($scope.featuredItems);    
                $http({
                        method: "post",
                        url:  "<?php echo $angularPost; ?>",
                        data: {vals: $scope.featuredItems, valOrig:$scope.originalFeaturedItems, option: 2 } 
                    }).then(function successCallback(good) {
                            //console.log(good.data.success); 
                            if(good.data.success == '1'){
                                $window.location.reload();
                            }else{
                                alert("Featured items cannot be empty!");
                            }  
                          
                         
                    }, function errorCallback(response) {
                        alert("Error updating the data");
                });       
}   

//Removed Featured Item
$scope.removeFeaturedItem = function(prim){
    console.log(prim);
    var myClass = angular.element( document.querySelector('.removeFeatured' + prim) );
   // myClass.addClass('displaynone'); 
   var arrayFeats = $scope.featuredItems;
   for(var i = 0; i < arrayFeats.length; i++) {
        var obj = arrayFeats[i];
        
        if(prim.indexOf(obj.Prim) !== -1) {
            arrayFeats.splice(i, 1);
            console.log(i);
            i--;
        }  
   } 
   
}

}); // end controller

 
 
</script>

