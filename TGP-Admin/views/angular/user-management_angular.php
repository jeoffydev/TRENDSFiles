
<?php
 
 


$sql= getCustomerData($table); 
 
$json_data=array();
foreach($sql as $rec)//foreach loop  
{  
    $json_array['CustomerNumber']=$rec['CustomerNumber']; 
     $json_array['Currency']=$rec['Currency'];  
    $json_array['CustomerName']= $rec['CustomerName']; 
    //$json_array['ThemedSiteMax']=$rec['ThemedSiteMax']; 
    
    $csr = explode('@', $rec['CSR']);  
    $json_array['CSR']=$csr[0]; 
    if($rec['CustomerOnHold'] == 'N'){
        $CustomerOnHold = 'No';
    }else{
        $CustomerOnHold = 'Yes';
    }
    $json_array['CustomerOnHold'] = $CustomerOnHold;
    array_push($json_data,$json_array);
} 
$customerData = json_encode($json_data,JSON_PRETTY_PRINT); 


 
 
$currencies= getCurrencyData($table); 
 
$json_currency=array(); 
foreach($currencies as $rec3)//foreach loop  
{  
  $rec3['currencyDescription'];
  $json_array3['currencyID']=$rec3['currencyID'];
  $json_array3['currencyName']= $rec3['currencyName'];  
  $json_array3['currencyDescription'] = $rec3['currencyDescription'];  
  array_push($json_currency,$json_array3);
} 
$currencyDatas = json_encode($json_currency,JSON_PRETTY_PRINT); 
 

/* Get all email user */

$userdatas = getUserData($table);
 

$json_userdatas=array(); 
foreach($userdatas as $rec4)//foreach loop  
{  
  
    if($rec4['CustomerOnHold'] == 'N'){
        $json_array4['userID']=$rec4['userID'];   
        $json_array4['userEmail']=$rec4['userEmail']; 
        $json_array4['userHash']=$rec4['userHash']; 
        $json_array4['userType']=$rec4['userType']; 
        $json_array4['multiCurrency']=$rec4['multiCurrency']; 
        $json_array4['skinnedWebsites']=$rec4['skinnedWebsites']; 
        $json_array4['customSiteUser']=$rec4['customSiteUser']; 
        $json_array4['CustomerNumber']=$rec4['CustomerNumber']; 
        $json_array4['CustomerName']=$rec4['CustomerName']; 
        $json_array4['Currency']=$rec4['Currency']; 

        /*if($rec4['CustomerOnHold'] == 'N'){
            $CustomerOnHold = 'No';
        }else{
            $CustomerOnHold = 'Yes';
        } */
        $json_array4['CustomerOnHold'] = $CustomerOnHold; 
        $json_array4['visualAccess']=$rec4['visualAccess']; 
        $json_array4['CSR']=$rec4['CSR']; 
        $json_array4['apiAcc']=$rec4['apiAcc']; 
        array_push($json_userdatas,$json_array4);
    }
   
  
} 
$userDatas = json_encode($json_userdatas,JSON_PRETTY_PRINT); 
 
  

function clean($string) { 
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}
 
//$angularPost = '/TGP-Admin/user-management';  
 

?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",function($scope, $http, $window, $timeout){

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.querySecond = {}
  $scope.queryBySecond = '$'
  $scope.customers = <?php echo $customerData; ?>;  
  $scope.orderProp="CustomerName";  
  $scope.userAdminEmail = '<?php echo $userEmail; ?>'; 
  $scope.currencyDatas = <?php echo $currencyDatas; ?>; 
  $scope.currencyDataModel = $scope.currencyDatas[0].currencyName;
  $scope.selectYesNoOption = {0:"No", 1:"Yes" };
  $scope.visualAccess = 0;
  $scope.visualAccessCheck = false;
  $scope.emailToFind = null;
  $scope.showEmailList = true;
  $scope.queryUsers = {}
  $scope.queryByUsers = '$'
  $scope.usersLists = <?php echo $userDatas; ?>;  
  $scope.userlistBox = null; 
  $scope.allemail = 0;
  $scope.hideDistributorEmail = true;
  $scope.onHoldSelectOne = $scope.selectYesNoOption[0]; 
  $scope.onHoldSelectTwo = $scope.selectYesNoOption[0]; 
  $scope.onHoldSelectThree = $scope.selectYesNoOption[0]; 
  $scope.customer ={};
  $scope.searchuser  = {};
  $scope.searchuserlist  = {}; 
  $scope.usersListsNew = 0;
  $scope.refreshing = false;
  $scope.searchuserUserEmail ="";
  $scope.searchuserCustomerName= "";
  $scope.listsAccnt = false;
  $scope.ansWerXC = "No"; 
  $scope.ansWerYC = "No"; 
  $scope.formData = {};

 //console.log($scope.ansWerXC + " / " + $scope.ansWerYC) 
 //$scope.searchuser.CustomerOnHold = "No";
 
 
 
 $scope.selectCustomerFirstNew = function(customerNumber, customerName, optional){
    optional = optional || 0;
    //console.log(customerNumber + " / " + customerName);

     $scope.tableTopBGTrigger(customerNumber);
    $http({
          method: "post",
          url:  "<?php  echo $angularPost; ?>", 
          data: {
            customerNumber: customerNumber, 
            option: 1, 
          },
      }).then(function successCallback(response) { 
            $scope.listsAccnt = response.data.customerAccess; 
            $scope.customerNumberedFirst = customerNumber;
            $scope.customerNamedFirst = customerName;

           // console.log(response.data.customerAccess);
            $scope.VASelectOption =  response.data.customerAccess.visualAccess;
            //console.log($scope.VASelectOption);
 
            $scope.userExists = false; 


            //Add users 
            $scope.addnewUserForm = function(){
               //console.log("Submitted!" +  $scope.formData);   
                    //Old variables
                    $scope.eml_add = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;  
                    $scope.formData.option = 2;
                    $scope.formData.customerNumber =  customerNumber;
                    $scope.formData.userAdminEmail = $scope.userAdminEmail;
                    $http({
                                method: "post",
                                url:  "<?php echo $angularPost; ?>",
                                data:  $.param($scope.formData),  // pass in data as strings
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' } 

                            }).then(function successCallback(good) { 
                                if(good.data.found == 1){
                                    $scope.userExists = true;
                                    $scope.userExists = 'Sorry, this email is already registered under account  ' + good.data.companyName;
                                }else{
                                    //$scope.searchuser.userEmail = $scope.formData.userEmail;
                                    $scope.userExists = 'New user added';
                                    $scope.formData.userEmail = '';  
                                    
                                    $scope.refreshUserDatas(); 
                                    $scope.usersListsNew = 0;


                                    $timeout(function() { 
                                            $scope.userExists = false;
                                    }, 2000);
                                    //Refresh table data
                                    
                                    
                                    //$scope.selectCustomerFirst($scope.customerNumbered, $scope.customerNamed);
                                    
                                }  

                            }, function errorCallback(response) {
                                alert("Error updating the data");
                    });        
            }



      }, function errorCallback(response) {
          alert("Error retrieving the data");
    });


 }


 /* Visual change */

    $scope.changeVisualNew = function(customerNumber, value){
                //console.log(customerNumber + "/" + value); 
                var val  = 0;  
                if(value == "Yes"){
                    val = 1;   
                }
                $http({
                                    method: "post",
                                    url:  "<?php echo $angularPost; ?>",
                                    data:  {customerNumber: customerNumber, val: value,  option: 10}  
                                }).then(function successCallback(saveRec) {
                                     //console.log(saveRec.data); 
                                    if(saveRec.data == 1){
                                            $scope.visualAccessCheck = true;
                                            $timeout(function() {
                                                $scope.visualAccessCheck = false;
                                                
                                            }, 2000);

                                    }
                                    
                                }, function errorCallback(response) {
                                    alert("Error updating Visual Access");
                });         
                
    }




$scope.checkIfOnHold2 = function(check){
    
    if(check == true){
        $scope.refreshUserDatas(1)
    }else{
        $scope.refreshUserDatas();
    }  
}

 /*  
$scope.showOnholdC = function(ansC){
   //console.log(ansB);
    if(ansC == 'Yes'){
        $scope.refreshUserDatas(1)
    }else{
        $scope.refreshUserDatas();
    }  
} */

   $scope.refreshUserDatas = function(opts){

    var opts = opts || null; 
    //console.log(opts);
               $http({
                                   method: "post",
                                   url:  "<?php echo $angularPost; ?>",
                                   data:  {option: 11, opts: opts}  
                               }).then(function successCallback(response) {
                                   $scope.refreshing = true;
                                   $timeout(function() {
                                               $scope.refreshing = false;
                                                
                                               
                                   }, 2000); 
                                    
                                   $scope.usersLists = response.data; 
                                   //console.log($scope.usersLists);
                                    
                                   
                                   
                                   
                               }, function errorCallback(response) {
                                   alert("Error retreiving all users");
               });         
 }


 
 
   
  
 var _timeout; 
$scope.activateAllSearch = function(){
        $scope.lists = false; 
        //console.log($scope.usersListsNew +  " $scope.usersListsNew");
        $scope.newString = null;
        $scope.newString2 = null;

        if($scope.searchuser ){
            $scope.newString = $scope.searchuser; 
        }
 
         

        if(_timeout) { // if there is already a timeout in process cancel it
                $timeout.cancel(_timeout);
        }
        _timeout = $timeout(function() {
                
                //console.log($scope.newString)
                //console.log( _timeout);
                if($scope.newString ){
                    $scope.searchusers  =  $scope.newString; 
                }
                 

                 

                if($scope.usersListsNew == 0){
                    $scope.usersLists = <?php echo $userDatas; ?>;  
                }else{ 
                    $scope.refreshUserDatas();
                
                }  
                   
                _timeout = null;
        },  800);
            
            
}

  $scope.selectCustomer = function(customerNumber, customerName, optional, userIDop,  userEmailop, selectYesNoFinop, selectYesNoCurrencyop, selectYesNoCustomop, selectYesNoSkinnedop,  userHashop, customerNumberedop, selectYesNoApiop ) {    
      //console.log(customerNumber);

      //console.log(customerNumber + " | " + customerName + " | " + optional + " | " + userIDop + " | " + userEmailop + " | " + selectYesNoFinop + " | " + selectYesNoCurrencyop + " | " + selectYesNoCustomop + " | " + selectYesNoSkinnedop + " | " + userHashop + " | " + customerNumberedop + " | " + selectYesNoApiop);
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
      }else{
        $scope.allemail = 0;
      } 
 

        if($scope.allemail == 1){
            $scope.showEmailList = true; 
            $scope.hideDistributorEmail = false;
        }else{
            $scope.showEmailList = false; 
            $scope.hideDistributorEmail = true;
        }
      
      $http({
          method: "post",
          url:  "<?php  echo $angularPost; ?>",
          data: {
            customerNumber: customerNumber, 
              option: 1, 
          },
      }).then(function successCallback(response) { 
             console.log(response.data);  
             $scope.lists = response.data.usersList; 

             //$scope.usersLists = response.data.usersList; 
              
             $scope.tableBGTrigger(userIDop);

             var countList = response.data.usersList.length
             //console.log(countList);  
             
             
             
             //Old variables
             $scope.visualAccess = response.data.customerAccess.visualAccess;  
             $scope.userCurrency = response.data.customerAccess.Currency; 
             $scope.userCSR = response.data.customerAccess.CSR; 
             var onHold;
             if(response.data.customerAccess.CustomerOnHold == 'N'){
                onHold = 'No';
             }else{
                onHold = 'Yes';
             }
             $scope.CustomerOnHold = onHold; 
             //$scope.visualAccessSelectOption = $scope.selectYesNoOption[$scope.visualAccess];


             $scope.customerNamed = customerName;
             $scope.customerNumbered = customerNumber;
             $scope.userExists = false; 
             


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
                        url:  "<?php echo $angularPost; ?>",
                        data:  {customerID: customerID, option: 3}  
                    }).then(function successCallback(removed) {
                        //console.log(removed.data); 
                        if(removed.data == 1){
                            
                            $scope.lists = false;
                            $scope.refreshUserDatas(); 
                            $scope.usersListsNew = 0;
                           
                        }
                    }, function errorCallback(response) {
                        alert("Error removing the data");
                });      
               
              } 
  }

$scope.ansWerX = 'No'; 
$scope.ansWerY = 'No';
/*
$scope.showOnhold = function(ans){
  //console.log(ans);
 if(ans == 'Yes'){
    $scope.ansWerX = 'No'; 
    $scope.ansWerY = 'Yes';
 }else{
    $scope.ansWerX = 'No'; 
    $scope.ansWerY = 'No'; 
 }  
} */

$scope.checkIfOnHold = function(check){
    //console.log(check);
    if(check == true){
        $scope.ansWerX = 'No'; 
        $scope.ansWerY = 'Yes';
    }else{
        $scope.ansWerX = 'No'; 
        $scope.ansWerY = 'No'; 
    }  
}

$scope.ansWerXB = 'No'; 
$scope.ansWerYB = 'No'; 

$scope.checkIfOnHold3 = function(check){
    //console.log(check);
    if(check == true){
        $scope.ansWerXB = 'No'; 
        $scope.ansWerYB = 'Yes';
    }else{
        $scope.ansWerXB = 'No'; 
        $scope.ansWerYB = 'No'; 
    }  
}

/*
$scope.showOnholdB = function(ansB){
   //console.log(ansB);
    if(ansB == 'Yes'){
        $scope.ansWerXB = 'No'; 
        $scope.ansWerYB = 'Yes';
    }else{
        $scope.ansWerXB = 'No'; 
        $scope.ansWerYB = 'No'; 
    }  
} */
 

 
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
                        url:  "<?php echo $angularPost; ?>",
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
 
 $scope.moveUser = function(userID,  userEmail, userCustNum,   CustomerName) {
    //console.log(userID + userEmail + userCustNum); 
    $scope.formMove = {};
    $scope.userEmail = userEmail;
    $scope.formMove.userCustNum = userCustNum; 
    $scope.customerNamedModal = CustomerName;
    $scope.customerNumberedModal = userCustNum;
   // $scope.selectCustomers = <?php // echo $customerData2; ?>; 
    var element = angular.element('#moveModal'); 
    element.modal('show');
    $scope.formMoveMessage = '';  
    $scope.moveUserFormsSubmitted = function(){

        //console.log($.param($scope.formMove));
        $scope.formMove.option = 5;
        $scope.formMove.userID = userID;
        $scope.formMove.userEmail = userEmail;
       
        var splitNameNumber = $scope.formMove.CustomerNumber.split(',');
        //console.log(splitNameNumber);
        var NewCustomerName = "";
        var NewCustomerNumber = "";
        if(splitNameNumber.length > 0){
            var NewCustomerNumber = splitNameNumber[0];
            var NewCustomerName = splitNameNumber[1];
        } 

        //console.log("This is the new customer now " + NewCustomerName + " / " + NewCustomerNumber);
        
        $http({
                          method: "post",
                          url:  "<?php echo $angularPost; ?>",
                          data:  $.param($scope.formMove),  
                          headers: { 'Content-Type': 'application/x-www-form-urlencoded' } 
       }).then(function successCallback(moved) {
                          //console.log(moved.data); 
                          if(moved.data == 0){ 

                            
                             //Hide Modal
                              var element = angular.element('#moveModal'); 
                              element.modal('hide'); 
                              //Restore  
                                $scope.lists = false;
                                $scope.refreshUserDatas(); 
                                $scope.usersListsNew = 0;

                                //console.log("https://api.trends.nz/api/v1/auth/updateuser?email="+$scope.formMove.userEmail+"&useracct=" + NewCustomerNumber + "&name=" + NewCustomerName );

                                //Update Email Primary Account https://api.trends.nz/api/v1/auth/updateuser?email=steveng@tuapeka.co.nz&useracct=10105 
                                $http({
                                        method: "post",
                                        url:  "https://api.trends.nz/api/v1/auth/updateuser?email="+$scope.formMove.userEmail+"&useracct=" + NewCustomerNumber + "&name=" + NewCustomerName,
                                        data:  {}  
                                    }).then(function successCallback(response) {
                                               
                                                console.log(response.data);
                                        
                                    }, function errorCallback(response) {
                                        alert("Error updating the user on API");
                                });  
                                //Update Email Primary Account


                             // $scope.selectCustomer($scope.customerNumbered, $scope.customerNamed); 
                          }else{
                              $scope.formMoveMessage = 'User and email already exists';
                          }
                         

          }, function errorCallback(response) {
                          alert("Error updating the data");
      });         
    }     

 }

 $scope.clearMessage = function(){
    $scope.formMoveMessage = '';
 }
 
 $scope.tableTopBGTrigger = function(acctID){
    var defaultBG = angular.element('.toptableRowBG');
        defaultBG.css('background-color', 'transparent');

    var elementBG = angular.element('.toptable' +acctID+'Row' ); 
        elementBG.css('background-color', '#aaaaaa');  
 }

 $scope.tableBGTrigger = function(userID){
    var defaultBG = angular.element('.tableRowBG');
        defaultBG.css('background-color', 'transparent');

    var elementBG = angular.element('.tableRow' + userID); 
        elementBG.css('background-color', '#aaaaaa');  
 }
 
 $scope.editUser = function(userID,  userEmail, usertype, currency, custom, skinned,  userHash, customerNumbered, apiAcc) {
    //console.log(userID + userEmail + usertype + currency); 
       //$scope.disabledForm();
       console.log("DITO AKO SA EDIT");
      
       $scope.tableBGTrigger(userID);

       $scope.userdatas = ''; 
       $http({
                          method: "post",
                          url:  "<?php echo $angularPost; ?>",
                          data:  {userID: userID, customerNumbered: customerNumbered, option: 6},   
       }).then(function successCallback(success) {
        
         // console.log(userID + '/' + userEmail + '/' + userHash + '/' + customerNumbered); 
         if(userHash == '' || userHash == null){
            $scope.resetpw(userID, userEmail, userHash, customerNumbered);
         }
         // Generate PW 
         $scope.generateUserID = userID;
         $scope.generateUserEmail = userEmail;
         $scope.generateUserHash = userHash;
         $scope.generateCustomerNumbered = customerNumbered;
         $scope.generateUsertype = usertype;
         $scope.generateCurrency = currency;
         $scope.generateCustom = custom;
         $scope.generateSkinned = skinned;
         $scope.generateApiAcc = apiAcc; 
         $scope.generateVisualAccess = success.data.visualAccessUser.visualAccess;

        //Secondary account
        
        $scope.secondaryAccounts = success.data.secondaryAccount;

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

		   console.log(success.data);
          $scope.selectYesNo = {0:"No", 1:"Yes" };
		  $scope.brandStoreAccess = {noAccess:"No Access", admin:"Admin", editor:"Editor" };
          $scope.selectUserType = {0:"Administrator", 1:"Normal" };
          //$scope.formEditUser.selectYesNoFin = $scope.selectYesNo[usertype];
          $scope.formEditUser.selectYesNoFin = $scope.selectUserType[success.data.userType];
          $scope.formEditUser.selectYesNoCurrency = $scope.selectYesNo[currency]; 
          $scope.formEditUser.selectYesNoCustom = $scope.selectYesNo[success.data.customSiteUser]; 
          $scope.formEditUser.selectYesNoSkinned = $scope.selectYesNo[skinned]; 
          $scope.formEditUser.selectYesNoApi = $scope.selectYesNo[apiAcc]; 
          $scope.formEditUser.selectYesNoOrderDashboard = $scope.selectYesNo[success.data.OrderDashboardAccess];
          $scope.formEditUser.brandStoreAccess = success.data.BrandStoreAccess;
		  $scope.formEditUser.brandStoreRole = success.data.BrandStoreRole;

          switch (success.data.BrandStoreAccess + '|' + success.data.BrandStoreRole)
		  {
			case '1|admin':
				$scope.formEditUser.brandStoreAccess = 'admin';
				break;
			case '1|editor':
				$scope.formEditUser.brandStoreAccess = 'editor';
				break;
			default:
				$scope.formEditUser.brandStoreAccess = 'noAccess';
				break;
		  }

          //VisualAccess for each company
         $scope.formEditUser.selectYesNoVisualAccess = $scope.selectYesNo[success.data.visualAccessUser.visualAccess];

          $scope.userEmail = userEmail;
          $scope.usertype = success.data.userType;   
          var element = angular.element('#editUserModal'); 
          //element.modal('show'); 
          $scope.resetpw_wrapper = false; 
          $scope.edituser_wrapper = true;
          
          //Submitted
          $scope.editUserFormsSubmitted = function(){
              $scope.formEditUser.option = 7;
              $scope.formEditUser.userID = userID;
             
              if($scope.formEditUser.selectYesNoFin == "Normal"){
                    $scope.formEditUser.selectYesNoFin = 1
              }
              if($scope.formEditUser.selectYesNoFin == "Administrator"){
                    $scope.formEditUser.selectYesNoFin = 0
              }

               if($scope.formEditUser.selectYesNoCurrency == "No"){
                    $scope.formEditUser.selectYesNoCurrency = 0
               }else{
                    $scope.formEditUser.selectYesNoCurrency = 1
               }

               if($scope.formEditUser.selectYesNoCustom == "No"){
                    $scope.formEditUser.selectYesNoCustom = 0
               }else{
                    $scope.formEditUser.selectYesNoCustom = 1
               }

               if($scope.formEditUser.selectYesNoSkinned == "No"){
                    $scope.formEditUser.selectYesNoSkinned= 0
               }else{
                    $scope.formEditUser.selectYesNoSkinned = 1
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

               //Order
               if($scope.formEditUser.selectYesNoOrderDashboard == "No"){
                    $scope.formEditUser.selectYesNoOrderDashboard= 0
               }else{
                    $scope.formEditUser.selectYesNoOrderDashboard = 1
               }

              //console.log($.param($scope.formEditUser));
            
              $http({
                          method: "post",
                          url:  "<?php echo $angularPost; ?>",
                          data:  $.param($scope.formEditUser),  
                          headers: { 'Content-Type': 'application/x-www-form-urlencoded' }    
              }).then(function successCallback(successEdit) {
                    console.log(successEdit.data);
                    if(successEdit.data.error)
                    { 
                      $scope.errorMarkup = successEdit.data.error.messageInt;  
                    }else{
                      $scope.errorMarkup = successEdit.data.message;   
                      $scope.selectCustomer($scope.customerNumbered, $scope.customerNamed, 1, userID,  userEmail, $scope.formEditUser.selectYesNoFin, $scope.formEditUser.selectYesNoCurrency, $scope.formEditUser.selectYesNoCustom, $scope.formEditUser.selectYesNoSkinned,  userHash, customerNumbered, $scope.formEditUser.selectYesNoApi);
                        
                    }

              }, function errorCallback(response) {
                  alert("Error updating the data");
              });  

          }


        }, function errorCallback(response) {
              alert("Error updating the data");
      });    

    

 }

 

 $scope.addSecondaryAccount = function(customerNumbered, customerNamed, newCurrency, customerNumber, customerName, generateUserID, userEmail, generateUsertype, generateCurrency, generateCustom, generateSkinned, generateUserHash, customerNumber, generateApiAcc){
    
        if (confirm("Are you sure you would like to give " + userEmail + " of account (" + customerNumbered + " - " + customerNamed + ") access to account (" + customerNumber + " - " + customerName + ")"  )) { 
            
            $http({
                                method: "post",
                                url:  "<?php echo $angularPost; ?>",
                                data:  {customerNumber: customerNumber, newCurrency: newCurrency, customerNumbered: customerNumbered, userID: generateUserID, userEmail: userEmail, customerName: customerName, option: 8},   
            }).then(function successCallback(success) {
                    
                    //console.log(success.data);
                    if(success.data == 1){
                        alert("Currency already exist in this user!");
                    }else if(success.data == 2){ 
                        alert("The selected currency is the user's primary one!");
                    }else{
                        $scope.selectCustomer(customerNumbered, customerNamed, 1, generateUserID,  userEmail, generateUsertype, generateCurrency, generateCustom, generateSkinned, generateUserHash, customerNumbered, generateApiAcc);
                    }
 
                }, function errorCallback(response) {
                    alert("Error adding second account");
            });    
        }  
    
 }

 $scope.removeSecondaryAccount = function(id, userID, userEmail, secondaryCurrency, secondaryAccountID, secondaryAccountName, primaryAccountID, customerNamed, generateUsertype,   generateCurrency, generateCustom, generateSkinned, generateUserHash, customerNumber, generateApiAcc){
        if (confirm("Are you sure you would like to remove " + userEmail + " of account (" + primaryAccountID + " - " + customerNamed + ") access to account (" + secondaryAccountID + " - " + secondaryAccountName + " " + secondaryCurrency + ")"  )) { 
             
            $http({
                                method: "post",
                                url:  "<?php echo $angularPost; ?>",
                                data:  {id: id,  option: 9},   
                }).then(function successCallback(deleted) {

                     
                    if(deleted.data == 1){
                        var element = angular.element('.' + id + '_DeleteSecondary'); 
                        element.css('display', 'none');
                    }
                      
                    
                }, function errorCallback(response) {
                    alert("Error deleting second account");
            });   

        }
 }  

 var _timeout;
$scope.lookForemail = function(emailToFind){ 
    //if(emailToFind.length > 0){ 
       
        //$scope.userlistBox = 'highlightThisBox'; 
    /*}else{
        $scope.showEmailList = false;
        $scope.userlistBox = null; 
    } */
   
    if(_timeout) {  
        $timeout.cancel(_timeout);
    }
    _timeout = $timeout(function() {
        //console.log(emailToFind);
        $scope.hideDistributorEmail = false;
        $scope.showEmailList = true;      
        _timeout = null;
    }, 1000);
}
$scope.selectThisUser = function(CustomerNumber, CustomerName, userID, userEmail, userType, multiCurrency, customSiteUser, skinnedWebsites, userHash, CustomerNumber2, apiAcc  ){ 

     if(userHash == '' || userHash == null){
        userHash  = 'tempHash';
     }

    //console.log(CustomerNumber + " = " + CustomerName + " = " + userID + " = " + userEmail + " = " + userType + " = " + multiCurrency + " = " + customSiteUser + " = " + skinnedWebsites + " = " + userHash + " = " + CustomerNumber2 + " = " + apiAcc);
    if(CustomerNumber && CustomerName && userID && userEmail && userType && multiCurrency && customSiteUser && skinnedWebsites && userHash && CustomerNumber2 && apiAcc)
    {  
        $scope.allemail = 1;
        $scope.tableBGTrigger(userID);
        $scope.selectCustomer(CustomerNumber, CustomerName, 1, userID, userEmail, userType, multiCurrency, customSiteUser, skinnedWebsites, userHash, CustomerNumber2, apiAcc);
    } 
                        
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

