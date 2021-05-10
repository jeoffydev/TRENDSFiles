 

<script> 
 
tgpApp.controller("skinneduserCtrl",function($scope, $http, $timeout){
   
    $scope.query = {}
    $scope.queryBy = '$'
    $scope.customers = <?=$customerData?>; 
    $scope.orderProp="CustomerName"; 
    $scope.userAdminEmail = '<?=$siteLogcheck['userDatas'][0]->userEmail?>'; 
    $scope.baseURL = '<?=base_url()?>';
    $scope.companyTagNameLabel = '';
    $scope.emailValidateBtnMsg = false;
    $scope.domainTrigger = 0;
    
    $scope.selectCustomer = function(customerNumber, customerName, opts) {    
            //console.log(customerNumber); 
            var opts = opts || null;
            $scope.usersExist = 0;
            $scope.companyTagNameLabel = ''; 
            $scope.emailValidateBtnMsg = false;
            $scope.themeUrl = '';

            $http({
                method: "post",
                url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                data: {
                    customerNumber: customerNumber, 
                    option: 1, 
                },
            }).then(function successCallback(response) { 
                    //console.log(response.data);  
 

                    //Back to default
                    if(!opts){
                        $scope.formDisabled = true;
                    } 
                    
                    //Result select company
                    $scope.disabledThemeAddField = true;
                    $scope.emailValidateBtn = true; 

                    $scope.formData = {};

                    $scope.customerName = customerName;
                    $scope.customerNumber = customerNumber; 
                    var myObject = response.data; 

                    $scope.lists = myObject;   
                    var listCount =  Object.keys(myObject).length;

                    $scope.displayListCount = listCount; 
                    //Result select company  

            

            }, function errorCallback(response) {
                console.log("Error retrieving the user data");
            });
    } 


    
 //Select theme site
$scope.selectTheme = function(customerNumber, selectedThemeID, companyTagName, domain){    
    var domain = domain || null;
    $scope.clearTableBG();
    $scope.formDisabled = false;
    $scope.usersExist = 0;
    $scope.companyTagNameLabel = companyTagName;
    $scope.emailValidateBtnMsg = false;
    $scope.formData = {};

    $scope.selectedThemeIDValid = selectedThemeID;
    $scope.customerNumberValid = customerNumber;
        
    if(domain == null){
        $scope.baseURL = '<?=base_url()?>';
        $scope.themeUrl = $scope.baseURL + 'home/ID' + customerNumber + selectedThemeID;
    }else{
        $scope.themeUrl = "//"+domain;
        $scope.baseURL = "//"+domain + "/";
        $scope.domainTrigger = 1;
    }    
        

    var element = angular.element('#'+ selectedThemeID); 
    element.css('background-color', 'rgb(171, 171, 171)');   

    //console.log("This theme " + selectedThemeID);

                $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                    data: {
                        selectedThemeID: selectedThemeID, 
                        customerNumber: customerNumber,
                        option: 2, 
                    },
                }).then(function successCallback(responseTheme) { 

                    if(responseTheme.data.length > 0){
                        $scope.usersExist = 1;
                        $scope.userLists = responseTheme.data;
                    } 
                    
                   // console.log(responseTheme.data);

                }, function errorCallback(responseTheme) {
                    console.log("Error retrieving the data from responseTheme");
                });  

}

$scope.validateThisEmail = function(email, ThemeID, customerNumber){
   
   var valid = $scope.validateEmail(email);
   $scope.emailValidateBtnMsg = false; 

   if(valid == true){ 
           $http({
                   method: "post",
                   url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                   data: {
                       ThemeID: ThemeID, 
                       customerNumber: customerNumber,
                       email: email,
                       option: 3, 
                   },
           }).then(function successCallback(responseEmail) { 

               //console.log(responseEmail.data);
               if(responseEmail.data == 0){
                   $scope.emailValidateBtn = false; 
                   $scope.emailValidateBtnMsg = false; 
               }
               if(responseEmail.data == 1){
                   $scope.emailValidateBtn = true;
                   $scope.emailValidateBtnMsg = 'Email address already exist!'; 
               } 


           }, function errorCallback(responseEmail) {
                   console.log("Error retrieving the data from responseTheme");
           });  

   }
   if(valid == false){
       $scope.emailValidateBtn = true; 
       $scope.emailValidateBtnMsg = 'Invalid Email Address'; 
   } 
}
 
$scope.addNewUserForm = function(themeID, customerNumber){
                //console.log('Eto ang form');
                //console.log("Ets - " + themeID + "/" +customerNumber);

                $scope.formData.themeID = themeID;
                $scope.formData.customerNumber = customerNumber;
                var companyTagNameLabel = $scope.companyTagNameLabel;
                var customerName = $scope.customerName;


                $scope.formDisabled = false;
                //console.log($scope.formData);
                $scope.formData.option = 4; 
                $scope.formData.baseUrl = $scope.baseURL;
                $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                    data:  $scope.formData,  
                }).then(function successCallback(responseAddUser) { 
                         console.log(responseAddUser.data); 
                        if(responseAddUser.data == 1){
                            
                            var element = angular.element('#successModal'); 
                            element.modal('show'); 
                            $scope.successMsg = 'Added new user!';
                                    
                            $timeout(function() { 
                                element.modal('hide'); 
                            }, 2000);
                            
                            <?php if($siteLogcheck['userDatas'][0]->userType == 0): ?>
                                $scope.selectCustomer(customerNumber, customerName, 1); 
                            <?php endif; ?>    
                            $scope.selectTheme(customerNumber, themeID, companyTagNameLabel);  
                        }

                }, function errorCallback(responseAddUser) {
                    console.log("Error retrieving the data from responseAddUser");
                });         
}


$scope.deleteSkinUser = function(skinnedUserID, customerNumber, customerName, companyTagNameLabel){
    if (confirm("Are you sure you want to delete this user?")) {  
        //console.log(skinnedUserID); 

                $http({
                    method: "post",
                    url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                    data:  { 
                        skinnedUserID: skinnedUserID,
                        option: 5,  
                    },  
                }).then(function successCallback(responseDeleteUser) { 
                        //console.log($scope.selectedThemeIDValid);  
                        <?php if($siteLogcheck['userDatas'][0]->userType == 0): ?>
                            $scope.selectCustomer(customerNumber, customerName, 1); 
                        <?php endif; ?>        
                        $scope.selectTheme(customerNumber, $scope.selectedThemeIDValid, companyTagNameLabel); 

                }, function errorCallback(responseDeleteUser) {
                    console.log("Error retrieving the data from responseDeleteUser");
                });         
    }
}


//View and Reset
$scope.viewResetPW = function(skinnedUserID, skinEmail, opts){
     
     $scope.headingModal = skinEmail;
     $scope.skinnedUserIDModal = skinnedUserID;
     $scope.themeCustomerLink =  'ID' + $scope.customerNumberValid + $scope.selectedThemeIDValid+ "/";  

     //console.log($scope.headingModal + " / " + $scope.skinnedUserIDModal + " / " + $scope.themeCustomerLink);    

     
                 $http({
                     method: "post",
                     url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                     data:  { 
                         skinnedUserID: skinnedUserID,
                         skinEmail: skinEmail, 
                         opts: opts,
                         option: 6,  
                     },  
                 }).then(function successCallback(responseResetUser) { 
                        //console.log(responseResetUser.data);    

                       
                            $scope.generateSkinReset = $scope.baseURL + "reset-user/" +  $scope.themeCustomerLink +  responseResetUser.data;
                        

                         var element = angular.element('#resetModal'); 
                         element.modal('show');     
                 }, function errorCallback(responseResetUser) {
                    console.log("Error retrieving the data from responseResetUser");
                 });   
  
}


//Reset PW only
$scope.resetPW = function(skinnedUserID, skinEmail, opts){
    if (confirm("Are you sure you want to generate new password for this user?")) {  
        //console.log(skinnedUserID);
        $scope.headingModal = skinEmail;
        $scope.skinnedUserIDModal = skinnedUserID;
        $scope.themeCustomerLink =  'ID' + $scope.customerNumberValid + $scope.selectedThemeIDValid + "/";   
        
  
       // console.log($scope.headingModal + " / " + $scope.skinnedUserIDModal + " / " + $scope.themeCustomerLink);    
                    $http({
                        method: "post",
                        url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                        data:  { 
                            skinnedUserID: skinnedUserID,
                            skinEmail: skinEmail, 
                            opts: opts,
                            option: 6,  
                        },  
                    }).then(function successCallback(responseResetUser) { 
                           //console.log(responseResetUser.data);    
                           //console.log("Hash " + responseResetUser.data.skinnedPwReset);    

                             
                                $scope.generateSkinReset = $scope.baseURL + "reset-user/" +  $scope.themeCustomerLink +  responseResetUser.data;
                             

                            var element = angular.element('#resetModal'); 
                            element.modal('show');     
                            
                    }, function errorCallback(responseResetUser) {
                        console.log("Error retrieving the data from responseResetUser");
                    });   
    }     

}

$scope.clearTableBG = function(){
    var element = angular.element('.themeTables'); 
    element.css('background-color', 'transparent');  
}
$scope.validateEmail = function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(re.test(String(email).toLowerCase())){
        return true;
    }else{
        return false;
    }  
}

$scope.copyUrl = function(copyUrl) { 
   document.querySelector('input#copyUrl').select();
   document.execCommand('copy'); 
}

}); // end controller
 
 
</script>
