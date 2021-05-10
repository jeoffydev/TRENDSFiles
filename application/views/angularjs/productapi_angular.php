 
<?php 
if( $siteLogcheck['loggedIn'] == 1):   

    $primaryAccount = $siteLogcheck['userDatas'][0]->userAcct;
    $CustomerName = $siteLogcheck['userDatas'][0]->CustomerName;
    $CustomerName = str_replace("'", "", $CustomerName);

    $userEmail = $siteLogcheck['userDatas'][0]->userEmail; 
    $userID = $siteLogcheck['userDatas'][0]->userID;

else: 
    $primaryAccount = null;
    $CustomerName = null;
    $userEmail = null;
    $userID = null;
endif; 
?>

<script>
 
 
    /*
	jQuery.noConflict();
	
	function signupAPIB() {   
		var request = jQuery.ajax({ url: "https://api.trendscollection.com/api/v1/auth/signup",
			type: "POST",
			data: { name: '', email: '' },
			dataType: "html"
		});
		request.done(function() { 
				 alert("All good!") 
		});
	};
	jQuery(document).ready(function(jQuery) {
		
	
    }); */
 
</script>
<script> 
 
tgpApp.controller("productapiCtrl",function($scope, $http, $timeout){
   
    $scope.primaryAccount = '<?php echo $primaryAccount; ?>';
    $scope.CustomerName = '<?php echo $CustomerName; ?>';
    $scope.userEmail = '<?php echo $userEmail; ?>';
    $scope.userID = '<?php echo $userID; ?>';

    <?php if($siteLogcheck['loggedIn'] == 1): ?>
        <?php if($siteLogcheck['userDatas'][0]->apiReq == 1): ?>
            $scope.registerMessage = false;
            $scope.registerSuccessMessage = true;
        <?php else: ?>
            $scope.registerMessage = true;
            $scope.registerSuccessMessage = false;
        <?php endif; ?>
    <?php endif; ?>    

    $scope.registerAPI = function(){

 
       $http({
                method: "POST", 
                url:  "https://api.trendscollection.com/api/v1/auth/signup",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                transformRequest: function(obj) {
                    var str = [];
                    for(var p in obj)
                        str.push(encodeURIComponent(p)+' = '+encodeURIComponent(obj[p]));

                    return str.join('&');
                },
                params: { name: $scope.CustomerName, email: $scope.userEmail, useracct: $scope.primaryAccount },
                dataType: "html",
               
            }).then(function successCallback(response) {

                 
                $scope.registerMessage = false;
                $scope.registerSuccessMessage = true;

                $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                data: { option: 1, userID: $scope.userID  } 
                    }).then(function successCallback(good) {
                            //console.log(good.data);
                            if(good.data ===  '1'){
                                    var element = angular.element('#successModal'); 
                                    element.modal('show'); 
                                    $scope.successMsg = 'Thank you for registering. Confirmation that we have received your registration has been sent to ' + $scope.userEmail;
                                    $timeout(function() {
                                        element.modal('hide'); 
                                    }, 900);
                            }
                            
                    }, function errorCallback(good) {
                        console.log("Error  updating user APIReq data");
                });     
 
            }, function errorCallback(response) {
                //console.log(response);
                alert("Error API request or  email has already been taken");
        });    


            
        
    }

}); // end controller
 
 
</script>
