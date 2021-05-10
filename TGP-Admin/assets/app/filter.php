<?php

    $json_data=array();
    foreach($sql as $rec)//foreach loop  
    {  
        $json_array['name']='Jeoffy';  
        $json_array['link']= 'Trends'; 
        array_push($json_data,$json_array);
    }
    $my_demos = json_encode($json_data,JSON_PRETTY_PRINT);

?>

<script>
// Define the `phonecatApp` module
var tgpApp = angular.module('tgpApp', []);

/*   
tgpApp.controller('bodyController', function bodyController($scope) {
  $scope.phones = [
    {
      name: 'Nexus S',
      snippet: 'Fast just got faster with Nexus S.',
      age: 1
    }, {
      name: 'Motorola XOOM™ with Wi-Fi',
      snippet: 'The Next, Next Generation tablet.',
      age: 2
    }, {
      name: 'MOTOROLA XOOM™',
      snippet: 'The Next, Next Generation tablet.',
      age: 3
    }
  ];
  $scope.orderProp = 'age';
}); */

 
tgpApp.controller("demoCtrl",function($scope){
  $scope.query = {}
  $scope.queryBy = '$'
  $scope.articles = <?php echo $my_demos; ?>;
  $scope.orderProp="name";                
});   
</script>

