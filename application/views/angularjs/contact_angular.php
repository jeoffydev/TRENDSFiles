<?php 

if($checkAvailCountry == "availNZ"){
    $emailExtension = ".co.nz";
}else{
    $emailExtension = ".com.au";
}

$infoTrendsEmail = "info@trendscollection" .$emailExtension;
 
?>

<script> 
 
tgpApp.controller("contactCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window', '$sce', '$compile',   function($scope,  $http, Upload, $timeout, $window, $sce, $compile){    

   
  /* Enquiry Form */
<?php if(count($customArray['themeArray']) > 0 || $siteLogcheck['loggedIn'] == 0): ?>    
    $scope.skinnedContactForm = {}; 
    
    $scope.alright = false; 
    $scope.alrightP = false; 
    $scope.skinnedContactForm.emailTo = '<?=$customArray['themeArray'][0]->Email?>';
    $scope.enquiryMsg = false;
    $scope.skinnedContactForm.infoEmail = '<?=$infoTrendsEmail?>';
    $scope.BotValue = false;
    
    $scope.skinnedFormCheck = function(opts, val){
        if(opts == 'email'){
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            if (!re.test(val)) 
            {
                $scope.alright = false;  
            }else{
                $scope.alright = true;  
            }
        }
        if(opts == 'phone'){
            var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;

            //if (!re.test(val))
            if(isNaN(val))
            { 
                $scope.alrightP = false;  
            }else{
                $scope.alrightP = true;  
               
               
            }
        }
    }

    $scope.makeBotTrue = function(val){
        if(val == true){
            $scope.BotValue = true;
        }else{
            $scope.BotValue = false;
        }
        
    }

    $scope.submitSkinnedContactForm = function(){
        //console.log($scope.skinnedContactForm);
        $scope.skinnedContactForm.option = 1;
        $scope.skinnedContactForm.BotValue = 0;


        //console.log($scope.skinnedContactForm.Human);
        //console.log($scope.BotValue);

        
        if($scope.BotValue == true){
            $scope.skinnedContactForm.BotValue = 1;
        }
       

        if($scope.skinnedContactForm.Human == true && $scope.BotValue == true){
            $http({
                        method: "post",
                        url:  "<?php echo base_url();?>Angular/ContactForm",
                        data: $scope.skinnedContactForm
                        
                }).then(function successCallback(response) {  
                        // console.log(response.data);   

                       $scope.enquiryMsg = true;   

                        var msg1 = "Your message has been sent. ";    

                        $scope.enquiryMsg = msg1;
                        $timeout(function() { 
                            $scope.enquiryMsg = false;  
                            $scope.skinnedContactForm = {};  
                        }, 3000);  
                    
                }, function errorCallback(response) {
                    console.log("Error retrieving the Contact form ");
            });    
        }
        


    }
<?php endif; ?>   

}]); // end controller
 
 
</script>
