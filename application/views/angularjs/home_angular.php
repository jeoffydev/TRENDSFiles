 
<?php 
/* Featured Items */

$json_data=array();
foreach($homeFeaturedProducts as $rec)//foreach loop  
{    
    
    $json_array = $this->productsdisplay_model->productsLoop($rec, $siteLogcheck, $customArray, $skinnedUserCheck);
    $json_array['Name'] = $this->general_model->cleanString($json_array['Name'], 1); 
    $json_array['FullName'] = $this->general_model->cleanString($json_array['FullName']); 
    
    array_push($json_data,$json_array);
} 
$myVisualProducts = json_encode($json_data,JSON_PRETTY_PRINT);  
 
 
?>
<script>
// Define the `phonecatApp` module

 
tgpApp.controller("homeCtrl",function($scope, $http){
   
    $scope.productFeaturedItems = <?php echo $myVisualProducts; ?>;
   // console.log(  $scope.productFeaturedItems);
    $scope.allProducts = false;
    $scope.displayProducts = function(){
        
        $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                data: { option: 1 } 
            }).then(function successCallback(good) {
                 $scope.allProducts = true;
                 $scope.allProducts = good.data;         
            }, function errorCallback(response) {
                console.log("Error  data");
        });     
    }


 

}); // end controller
 
 
</script>
