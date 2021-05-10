
<?php

$sql= getCustomerData($table); 
 
$json_data=array();
foreach($sql as $rec)//foreach loop  
{  
  $json_array['CustomerNumber']=$rec['CustomerNumber']; 
  //$json_array['Currency']=$rec['Currency'];  
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



//Only CustomerOnHold NO
$sql2= getCustomerDataNo($table); 
 
$json_data2=array();
foreach($sql2 as $rec2)//foreach loop  
{  
  $json_array2['CustomerNumber']=$rec2['CustomerNumber']; 
  //$json_array2['Currency']=$rec2['Currency'];  
  $json_array2['CustomerName']= $rec2['CustomerName']; 
  //$json_array2['ThemedSiteMax']=$rec2['ThemedSiteMax']; 
  $json_array2['CSR']=$rec2['CSR']; 
  if($rec2['CustomerOnHold'] == 'N'){
      $CustomerOnHold2 = 'No';
  }else{
    $CustomerOnHold2 = 'Yes';
  }
  $json_array2['CustomerOnHold'] = $CustomerOnHold2;
  array_push($json_data2,$json_array2);
} 
//$customerData2 = json_encode($json_data2,JSON_PRETTY_PRINT); 
 


function clean($string) { 
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}
?>

<script>
// Define the `phonecatApp` module

 
 tgpApp.controller("editCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window',  function($scope, $http, Upload, $timeout, $window){  

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.customers = <?php echo $customerData; ?>; 
  $scope.orderProp="CustomerName";  
  $scope.userAdminEmail = '<?php echo $userEmail; ?>'; 
  $scope.bannerNewForm = {};
  $scope.selectDropdown = {0:"No", 1:"Yes"}; 
  $scope.selectPopup = {0:"Current Window", 1:"Open in Pop Up", 2: "Open in New Window"};
  $scope.bannerNewForm.bannerSkinnedSite = false;
  $scope.bannerSkinnedSiteForm = false;
  $scope.formfieldBanner = true; 


  $scope.selectCustomer = function(customerNumber, customerName, optional, userIDop,  userEmailop, selectYesNoFinop, selectYesNoCurrencyop, selectYesNoCustomop, selectYesNoSkinnedop,  userHashop, customerNumberedop, selectYesNoApiop) {    
      //console.log(customerNumber);
      $scope.resetpw_wrapper = false;
      $scope.edituser_wrapper = false;  
      $scope.formfieldBanner = true;
      $scope.bannerNewForm.url = null;
      $scope.userEmail = null;  
      $scope.formfieldBanner = true; 
      $scope.bannerSkinnedSiteForm = false;
      

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

        $scope.formfieldBanner = false;  
        $scope.bannerSkinnedSiteForm = false;

        var fileElement = angular.element('#mainfileUpload');
        angular.element(fileElement).val(null);
      
      $http({
          method: "post",
          url:  "<?php  echo $angularPost; ?>",
          data: {
            customerNumber: customerNumber, 
              option: 1, 
          },
      }).then(function successCallback(response) { 
             console.log(response.data);  
             $scope.lists = response.data; 
             $scope.customerNamed = customerName;
             $scope.customerNumbered = customerNumber;
             $scope.userExists = false; 

            $scope.eml_add = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/; 
            $scope.formData = {};
            $scope.formData.option = 2;
            $scope.formData.customerNumber = customerNumber;
            

            if(response.data != '0'){
                $scope.bannerNewForm.bannerSkinnedSite = response.data;  
                $scope.bannerSkinnedSiteForm = true;
            }
                
            


      }, function errorCallback(response) {
          alert("Error retrieving the data");
      });
  }

 
 
  
 
 $scope.clearMessage = function(){
    $scope.formMoveMessage = '';
 }
 
 //list.userID, list.userEmail, customerNamed, customerNumbered
 $scope.editUser = function(userID,  userEmail,  customerNamed, customerNumbered) {
     //console.log(userID + userEmail + "/" + usertype + "/" + customerNamed + "/" + customerNumbered); 
       //$scope.disabledForm();
       
          $scope.userEmail = userEmail;
          $scope.userID = userID;
          $scope.formfieldBanner = false; 
          $scope.customerName = customerNamed;
          $scope.customerNumber = customerNumbered; 
          $scope.bannerSkinnedSiteForm = false;

           var fileElement = angular.element('#mainfileUpload');
            angular.element(fileElement).val(null);
 

            $http({
                    method: "post",
                    url:  "<?php  echo $angularPost; ?>",
                    data: {
                        userID: userID, 
                        option: 2, 
                    },
            }).then(function successCallback(response) { 
                   // console.log(response.data.bannerIDs.userBanner);
                   // console.log(response.data.bannerResults);   
                     
                    $scope.bannerNewForm.bannerIDs = response.data.bannerIDs.userBanner;
               
                    $scope.bannerNewForm.bannerSkinnedSite =   response.data.bannerResults;
                    if(response.data.bannerResults.length > 0){
                        $scope.bannerSkinnedSiteForm = true;
                    }
                    

            }, function errorCallback(response) {
                console.log("Error retrieving the user banner data");
            });

 }

  /* Add new form banner */
  $scope.addNewBannerForm = function(file,   customerName, customerNumber){

     
            if($scope.bannerNewForm.url == "" || $scope.bannerNewForm.url == null){ 
                alert("URL is required and cannot be empty");
                return;
            } 
            if($scope.bannerNewForm.ThemeIDUrl == '' )
            { 
                alert("Location is required and cannot be empty");
                return;
            } 

            if( !file.name ){
                alert("File image is required and cannot be empty");
                return;
            } 

            if( file.type != 'image/jpeg' ){
                alert("File image must be jpeg");
                return;
            } 
            //console.log(file); 
            //console.log(  customerName + " / " +  customerNumber); 
            //console.log($scope.bannerNewForm); 

            if(file){ 
                file.upload = Upload.upload({
                    url: '<?php echo $angularPost; ?>',
                    data: {option: 3, file: file, bannerData: $scope.bannerNewForm, customerNumber: customerNumber },
                });

                file.upload.then(function (response ) {   
                      //console.log(response.data);        

                       $scope.success('Uploaded new banner');
                       $scope.selectCustomer(customerNumber, customerName);
                      // $scope.editUser(userID,  userEmail,  customerName, customerNumber);
                                
                }, function (response) {
                    if (response.status > 0)
                        $scope.errorMsg = response.status + ': ' + response.data;
                });  
            }   


}

$scope.editBannerForm = function(customerNamed, customerNumbered){
        //console.log(userID);
        console.log($scope.bannerNewForm.bannerSkinnedSite); 
         
         $scope.bannerMsg = 'Banner updated successfuly!'; 
       
       $http({
                method: "post",
                url:  "<?php echo $angularPost; ?>",
                data: {  option: 4, updateData: $scope.bannerNewForm.bannerSkinnedSite, customerNumbered: customerNumbered } 
            }).then(function successCallback(responseUpdate) { 
                //console.log(responseUpdate.data);   
                if(responseUpdate.data.success == '1'){
                    $scope.success($scope.bannerMsg);        
                }else{
                    alert("Banner items cannot be empty!");
                }   
            }, function errorCallback(responseUpdate) {
                        console.log("Error updating the skinned banner");
        });        
                    
  }


  
$scope.deleteBanner = function(id, filename,  customerName, customerNumber  ){ 
            
        if (confirm("Are you sure you want to delete  this banner?")) {  
            
         //console.log(id + "/" + filename + " / "  + customerName + " / " + customerNumber  );
          $http({
                    method: "post",
                    url:  "<?php  echo $angularPost; ?>",
                    data: {
                        id: id,
                        customerNumber: customerNumber,
                        filename: filename, 
                        option: 5 
                    },
            }).then(function successCallback(responseDel) { 
                //console.log(responseDel.data);  
                if(responseDel.data == 'success'){
                    //var elementDel = angular.element('#bannerRemove' + id); 
                    //elementDel.css('display', 'none'); 
                    $scope.success('Banner deleted!');       
                    $scope.selectCustomer(customerNumber, customerName);
                     

                }
                
            }, function errorCallback(responseDel) {
                console.log("Error retrieving the responseDel");
            });   
        }
}


$scope.ansWer = 'No'; 
$scope.showOnhold = function(ans){
  console.log(ans);
  $scope.ansWer = ans; 
}

//Disabled form
$scope.disabledForm = function(){
          $scope.selectUserType = null; 
          $scope.selectYesNo = null; 
          $scope.userEmail = null;
          $scope.userdatas = null;
}


   $scope.success = function(msg){
        var element = angular.element('#successModal'); 
        element.modal('show'); 
        $scope.successMsg = msg;
        $timeout(function() {
            element.modal('hide'); 
        }, 900);  
  }

}]); // end controller

 
 
</script>

