 
<?php 
/* Favourite Items */

$json_data=array();
foreach($getFavourites as $rec)//foreach loop  
{    
    
    $json_array = $this->productsdisplay_model->productsLoop($rec, $siteLogcheck, $customArray, $skinnedUserCheck);

    array_push($json_data,$json_array);
} 
$myFavouriteProducts = json_encode($json_data,JSON_PRETTY_PRINT);  

 
?>

<script> 
  
tgpApp.controller("favouritesCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window', '$sce', '$compile',   function($scope,  $http, Upload, $timeout, $window, $sce, $compile){ 

    $scope.myFavouriteItems = <?php echo $myFavouriteProducts; ?>;

   

}]); // end controller
 
 
</script>
