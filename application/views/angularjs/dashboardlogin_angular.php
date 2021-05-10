 


<script> 
 
tgpApp.controller("dashboardloginCtrl",function($scope, $http, $timeout){
	 
   
    $scope.reloadToDashboard = function(){ 
        window.location.href = '<?=base_url();?>' + 'dashboard';
    }

}); // end controller
 
 
</script>
