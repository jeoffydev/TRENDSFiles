<?php if( count($customArray['themeArray']) > 0): 
		if($verifiedEmail):
?>
<script>
// Define the `phonecatApp` module

 
tgpApp.controller("resetuserCtrl",function($scope, $http, $timeout, $window){
     $scope.verifiedPassword = true;
     $scope.pwMsg = false;
     $scope.formData = {};
     $scope.formData.skinnedUserID = <?=$skinnedUserID?>;
     $scope.formData.customsiteID = <?=$customsiteID?>;

     $scope.initialPopup = function(){
        var element = angular.element('#resetUserModal'); 
            element.modal('show');     
     }

    $scope.verifyPassword = function(password1, password2){ 
            if(password1 !== password2){
                $scope.pwMsg = true;
                $scope.verifiedPassword = true;
                $scope.pwMsg = "Password doesn't match";
            }else{
                $scope.pwMsg = false; 
                $scope.verifiedPassword = false;
            }
            
            $scope.validatePasswordChange = function(){
                console.log($scope.formData);

                $scope.formData.option = 1;

                $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                    data:  $scope.formData,  
                }).then(function successCallback(responseChangePw) { 
                         console.log(responseChangePw.data); 

                         if(responseChangePw.data == 1){
                            var element = angular.element('#resetUserModal');  
                                element.modal('hide'); 

                            var element2 = angular.element('#successModal'); 
                            element2.modal('show'); 
                            $scope.successMsg = 'Password changed successfully!';
                                    
                            $timeout(function() { 
                                element2.modal('hide'); 
                            }, 2000);

                            $timeout(function() {
                                $window.location.reload();
                            }, 600);   


                         }

                         
                }, function errorCallback(responseChangePw) {
                    console.log("Error retrieving the data from responseChangePw");
                });     
            }
        
    }
 

}); // end controller
 
 
</script>
	<?php endif; ?>
<?php endif; ?>