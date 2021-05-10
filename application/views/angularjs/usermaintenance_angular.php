 
 
<script> 
 
tgpApp.controller("usermaintenanceCtrl",function($scope, $http, $timeout){
   
    $scope.query = {}
    $scope.queryBy = '$'
    $scope.customers = <?=$customerData?>; 
    $scope.orderProp="CustomerName"; 
    $scope.userAdminEmail = '<?=$siteLogcheck['userDatas'][0]->userEmail?>'; 
    $scope.baseURL = '<?=base_url()?>';
    $scope.companyTagNameLabel = '';
    $scope.emailValidateBtnMsg = false;
    $scope.domainTrigger = 0;
    
     


    

  $scope.selectCustomer = function(customerNumber, customerName, optional, userIDop,  userEmailop, selectYesNoFinop, selectYesNoCurrencyop, selectYesNoCustomop, selectYesNoSkinnedop,  userHashop, customerNumberedop, selectYesNoApiop) {    
      //console.log(customerNumber);
      $scope.resetpw_wrapper = false;
      $scope.edituser_wrapper = false;  
      $scope.disabledForm();

      optional = optional || 0;
      userIDop = userIDop || 0;
      userEmailop = userEmailop || 0;
      selectYesNoFinop = selectYesNoFinop || 0;
      selectYesNoCurrencyop = selectYesNoCurrencyop || 0;
      selectYesNoCustomop = selectYesNoCustomop || 0;
      selectYesNoSkinnedop = selectYesNoSkinnedop || 0;
      userHashop = userHashop || 0;
      customerNumberedop = customerNumberedop || 0;
      selectYesNoApiop = selectYesNoApiop || 0;

      if(optional > 0) { 
          $scope.editUser(userIDop,  userEmailop, selectYesNoFinop, selectYesNoCurrencyop, selectYesNoCustomop, selectYesNoSkinnedop,  userHashop, customerNumberedop, selectYesNoApiop)  
      } 
      
      $http({
          method: "post",
          headers: { "Content-Type": "application/json" },
          url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
          data: {
            customerNumber: customerNumber, 
              option: 1, 
          },
      }).then(function successCallback(response) { 
           // console.log(response.data);  
             $scope.lists = response.data; 
             $scope.customerNamed = customerName;
             $scope.customerNumbered = customerNumber;
             $scope.userExists = false; 

            $scope.eml_add = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/; 
            $scope.formData = {};
            $scope.formData.option = 2;
            $scope.formData.customerNumber = customerNumber;
            $scope.formData.userAdminEmail = $scope.userAdminEmail;

             

            $scope.addnewUserForm = function(){
              //console.log("Submitted!" +  $scope.formData);  
              $http({
                        method: "post",
                        url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                        data:  $scope.formData,  // pass in data as strings 

                    }).then(function successCallback(good) { 
                            //console.log(good.data);  
                            //console.log(good.data.found);  
                           // console.log(good.data.companyName);  
                           if(good.data.found == 1){
                              $scope.userExists = true;
                              $scope.userExists = 'Sorry, this email is already registered under account  ' + good.data.companyName;
                           }else{
                              $scope.userExists = 'New user added';
                              $scope.formData.userEmail = ''; 
                              $timeout(function() {
                                  $scope.userExists = false;
                              }, 2000);
                              //Refresh table data
                              $scope.selectCustomer($scope.customerNumbered, $scope.customerNamed)
                           }  

                    }, function errorCallback(response) {
                        alert("Error updating the data");
              });        
            }


      }, function errorCallback(response) {
          alert("Error retrieving the data");
      });
  }

    $scope.resetpw_wrapper = false;
    $scope.edituser_wrapper = false;
    $scope.removeCustomer = function(customerID, customerEmail) {
                //console.log(customerID + $scope.customerNumbered + $scope.customerNamed); 
                if (confirm("Are you sure you want to delete " + customerEmail + "?")) { 
                    $http({
                            method: "post",
                            url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                            data:  {customerID: customerID, option: 3}  
                        }).then(function successCallback(removed) {
                           // console.log(removed.data); 
                            if(removed.data == 1){
                                $scope.selectCustomer($scope.customerNumbered, $scope.customerNamed);
                                $scope.resetpw_wrapper = false;
                                $scope.edituser_wrapper = false;
                            }
                        }, function errorCallback(response) {
                            alert("Error updating the data");
                    });      
                
                } 
    }
 


 $scope.clearMessage = function(){
    $scope.formMoveMessage = '';
 }


 
 $scope.editUser = function(userID,  userEmail, usertype, currency, custom, skinned,  userHash, customerNumbered, apiAcc) {
            //console.log(userID + userEmail + usertype + currency); 
            //$scope.disabledForm();
            $scope.userdatas = ''; 
            $http({
                                method: "post",
                                url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                                data:  {userID: userID, customerNumbered: customerNumbered, option: 6},   
            }).then(function successCallback(success) {

                //console.log(success.data);
                // console.log(userID + '/' + userEmail + '/' + userHash + '/' + customerNumbered); 
                if(userHash == '' || userHash == null){
                    $scope.resetpw(userID, userEmail, userHash, customerNumbered);
                }
                // Generate PW 
                $scope.generateUserID = userID;
                $scope.generateUserEmail = userEmail;
                $scope.generateUserHash = userHash;
                $scope.generateCustomerNumbered = customerNumbered;


                


                //console.log(success.data.markup1 );
                $scope.errorMarkup = ''; 
                $scope.formEditUser = {};
                
                $scope.formEditUser.markup1 = success.data.markup1; 
                $scope.formEditUser.markup2 = success.data.markup2; 
                $scope.formEditUser.markup3 = success.data.markup3; 
                $scope.formEditUser.markup4 = success.data.markup4; 
                $scope.formEditUser.markup5 = success.data.markup5; 
                $scope.formEditUser.setupMarkup = success.data.setupMarkup; 
                //$scope.formEditUser.selectAccessPages = success.data.selectAccess;
                //$scope.formEditUser.userAccess = success.data.userAccess; 
                    


                //User's Access  starts here
                $scope.formEditUser.pageNumberSelected = []; 
                $scope.selectionAccess = []; 
                var arrayAccess;  
                if(success.data.userAccess != null){
                        arrayAccess = success.data.userAccess.split(','); 
                }else{
                        arrayAccess = null;
                }   
                //console.log(arrayAccess);  
                $scope.fruits = success.data.selectAccess;
                $scope.selectionAccess = arrayAccess;
                $scope.formEditUser.pageNumberSelected = arrayAccess;
                
                $scope.toggleSelectionAccess = function (fruitName) {
                        
                            if($scope.selectionAccess == null){
                                $scope.countAccess = parseInt(fruitName);   
                                if($scope.countAccess >= 0){ 
                                    var arrs = []; 
                                    arrs.push(fruitName);  
                                } 
                                $scope.selectionAccess = arrs;
                                //console.log($scope.selectionAccess);  
                                //console.log("FIrst");
                            }else{
                                var idx = $scope.selectionAccess.indexOf(fruitName); 
                                // Is currently selected
                                if (idx > -1) {
                                    $scope.selectionAccess.splice(idx, 1);
                                    //console.log("BAwas");
                                } 
                                // Is newly selected
                                else {
                                    $scope.selectionAccess.push(fruitName);
                                    //console.log("Dagdag");
                                }
                            } 
                        
                        $scope.formEditUser.pageNumberSelected = $scope.selectionAccess;       
                        
                    };
                    //console.log($scope.selectionAccess);
                //User's Ends  starts here
                    
                
                $scope.selectYesNo = {0:"No", 1:"Yes" };
                $scope.selectUserType = {0:"Administrator", 1:"Normal" };
                //$scope.formEditUser.selectYesNoFin = $scope.selectYesNo[usertype];
                $scope.formEditUser.selectYesNoFin = $scope.selectUserType[usertype];
                $scope.formEditUser.selectYesNoCurrency = $scope.selectYesNo[currency]; 
                $scope.formEditUser.selectYesNoCustom = $scope.selectYesNo[custom]; 
                $scope.formEditUser.selectYesNoSkinned = $scope.selectYesNo[skinned]; 
                $scope.formEditUser.selectYesNoApi = $scope.selectYesNo[apiAcc]; 

                //VisualAccess for each company
                $scope.formEditUser.selectYesNoVisualAccess = $scope.selectYesNo[success.data.visualAccessUser.visualAccess];

                $scope.userEmail = userEmail;
                $scope.usertype = usertype;   
                var element = angular.element('#editUserModal'); 
                //element.modal('show'); 
                $scope.resetpw_wrapper = false; 
                $scope.edituser_wrapper = true;



                //Submitted
                $scope.editUserFormsSubmitted = function(){
                    $scope.formEditUser.option = 7;
                    $scope.formEditUser.userID = userID;
                    
                    /* if($scope.formEditUser.selectYesNoFin == "Normal"){
                            $scope.formEditUser.selectYesNoFin = 1
                        }
                        if($scope.formEditUser.selectYesNoFin == "Administrator"){
                                $scope.formEditUser.selectYesNoFin = 0
                        }
                        
                        if($scope.formEditUser.selectYesNoCustom == "No"){
                                $scope.formEditUser.selectYesNoCustom = 0
                        }else{
                                $scope.formEditUser.selectYesNoCustom = 1
                        }
                        if($scope.formEditUser.selectYesNoApi == "No"){
                                $scope.formEditUser.selectYesNoApi= 0
                        }else{
                                $scope.formEditUser.selectYesNoApi = 1
                        }

                        //VisualAccess
                        $scope.formEditUser.customerNumbered = $scope.customerNumbered;
                        if($scope.formEditUser.selectYesNoVisualAccess == "No"){
                                $scope.formEditUser.selectYesNoVisualAccess= 0
                        }else{
                                $scope.formEditUser.selectYesNoVisualAccess = 1
                        }

                        if($scope.formEditUser.selectYesNoSkinned == "No"){
                            $scope.formEditUser.selectYesNoSkinned= 0
                        }else{
                                $scope.formEditUser.selectYesNoSkinned = 1
                        }
                    
                    */

                    if($scope.formEditUser.selectYesNoCurrency == "No"){
                            $scope.formEditUser.selectYesNoCurrency = 0
                    }else{
                            $scope.formEditUser.selectYesNoCurrency = 1
                    }

                   

                    

                    

                    //console.log($.param($scope.formEditUser));
                    
                    $http({
                                method: "post",
                                url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                                data:  $scope.formEditUser,      
                    }).then(function successCallback(successEdit) {
                            //console.log(successEdit.data);
                            if(successEdit.data.error)
                            { 
                                $scope.errorMarkup = successEdit.data.error;  
                            }else{
                                $scope.errorMarkup = successEdit.data.message;    
                                $scope.selectCustomer($scope.customerNumbered, $scope.customerNamed, 1, userID,  userEmail, null, $scope.formEditUser.selectYesNoCurrency, null, $scope.formEditUser.selectYesNoSkinned,  userHash, customerNumbered, null);
                            } 

                    }, function errorCallback(response) {
                        alert("Error updating the data");
                    });  

                }
                
                


                }, function errorCallback(response) {
                    alert("Error updating the data");
            });    
 
 }


 
 $scope.resetpw = function(userID, userEmail, hash, userCustNum) {
       //console.log(userID + " - " + hash);
                 
                    if(hash == '' || hash == null){
                        hash = 0;
                    }else{
                        hash = 1;
                        if (confirm("Are you sure you want to generate a new password?")) { 
                            
                        }else{
                            return false;
                        }
                    }
                 

                $http({
                        method: "post",
                        url:  "<?php echo base_url();?>Angular/<?php echo $angularFile; ?>AngularPost",
                        data:  {userID: userID, hash: hash, userCustNum: userCustNum, option: 4}  
                    }).then(function successCallback(userdata) {
                         //console.log(userdata.data); 
                        
                        $scope.userdatas = userdata.data;
                        $scope.userEmail = userEmail;
                        var element = angular.element('#resetpwModal'); 
                        //element.modal('show');
                        $scope.resetpw_wrapper = true; 
                        $scope.edituser_wrapper = false;  
                         
                    }, function errorCallback(response) {
                        alert("Error updating the data");
                });              
}  

 $scope.copyUrl = function(copyUrl) {
   //console.log(copyUrl);
   document.querySelector('input#copyUrl').select();
   document.execCommand('copy'); 
 }
 
    $scope.ansWer = 'No'; 
        $scope.showOnhold = function(ans){
            $scope.ansWer = "";
            console.log(ans);

            if(ans === true){
                ans = "";
            }else{
                ans = "Y";
            }
            
        //console.log(ans);
        $scope.ansWer = ans; 
        console.log($scope.ansWer);
    }
    //Disabled form
    $scope.disabledForm = function(){
            $scope.selectUserType = null; 
            $scope.selectYesNo = null; 
            $scope.userEmail = null;
            $scope.userdatas = null;
    }

}); // end controller
 
 
</script>
