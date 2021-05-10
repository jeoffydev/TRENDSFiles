
<?php
 
$sql= getProducts($table); 
 
$json_data=array(); 
foreach($sql as $rec)//foreach loop  
{  
    
  
        $json_array['id']=$rec['id']; 
        $json_array['filename']=$rec['filename']; 
        $json_array['url']=$rec['url'];  
        $json_array['location']=$rec['location']; 
        $json_array['orderNum']=$rec['orderNum']; 
        $json_array['main']=$rec['main']; 
        $json_array['popup']=$rec['popup']; 
        $json_array['openWindow']=$rec['openWindow']; 
        $json_array['active']=$rec['active']; 
        array_push($json_data,$json_array);
     
    
} 




$my_products = json_encode($json_data,JSON_PRETTY_PRINT);  

function clean($string) { 
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}

 

?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",  ['$scope', '$http',  'Upload', '$timeout',  function($scope, $http, Upload, $timeout){  

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.publicBanner = <?php echo $my_products; ?>; 
  $scope.publicBannerShow = true;
  $scope.bannerLocation = 'Banners_loggedout'; 
  $scope.NZBannerShow = false; 
  $scope.NZBanner = '';
  $scope.AUBannerShow = false;
  $scope.AUBanner = '';
  $scope.publicForm = {};
  $scope.public = 'public';
  $scope.nz = 'nz';
  $scope.au = 'au';
  $scope.sg = 'sg';
  $scope.my = 'my';
  $scope.publicActive = 'active btn-dark';
  $scope.btn = 'Public';
  $scope.formCondition = $scope.public; 
  $scope.locNew = 'public';
  $scope.bannerNewForm = {};
  $scope.selectDropdown = {0:"No", 1:"Yes"}; 
  $scope.selectPopup = {0:"Current Window", 1:"Open in Pop Up", 2: "Open in New Window"};
  $scope.selectLocation = {0:$scope.public, 1:$scope.nz, 2:$scope.au, 3:$scope.sg, 4:$scope.my}
  var defaultLoc = {
    public: true
  };
  $scope.bannerNewForm.location = defaultLoc;
  $scope.bannerNewForm.url = null;
  $scope.popupFormLocation = null;

  /* Add new form banner */
  $scope.addNewBannerForm = function(file){

      $scope.bannerNewForm.url != null
      if($scope.bannerNewForm.url == "" || $scope.bannerNewForm.url == null){ 
            alert("URL is required and cannot be empty");
            return;
      } 
      if(isEmpty($scope.bannerNewForm.location) == 0 )
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

       // console.log(file);
        //console.log($scope.bannerNewForm); 
        
        
            if(file){ 
                file.upload = Upload.upload({
                    url: '<?php echo $angularPost; ?>',
                    data: {options: 4, file: file, bannerData: $scope.bannerNewForm },
                });

                file.upload.then(function (response ) {   
                        //console.log(response.data);        
                        
                        //reset fields
                        if(response.data.success == '1'){
                            $scope.bannerNewForm.url = null;
                            $scope.picFile = {};
                            var inputElem = angular.element("input[type='file']");
                            angular.element(inputElem).val(null);
                            $scope.success("New banner uploaded");   
                            $scope.activateBanner(response.data.defeaultOn);
                        } 
                       
                                
                }, function (response) {
                    if (response.status > 0)
                        $scope.errorMsg = response.status + ': ' + response.data;
                }); 
            }  

     

    
  } 
  function isEmptyFile(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}


  function isEmpty(obj) {
    var results = []; 
    for(var key in obj) { 
        if(obj[key] == true){
            results.push(key);  
        } 
    } 
    return results;
  }
  /* Add new form banner */

  $scope.activateBanner = function(loc){
        /* $scope.publicBannerShow = false;
        $scope.NZBannerShow = false; 
        $scope.AUBannerShow = false; */

        $scope.locNew = loc;
        $scope.bannerNewForm.location = {};
        $scope.publicActive = '';
        $scope.nzActive = '';
        $scope.auActive = '';
        $scope.sgActive = '';
        $scope.myActive = '';

        if(loc == $scope.public){
           // $scope.publicBannerShow = true; 
           $scope.publicActive = 'active btn-dark';
           $scope.btn = 'Public';
           $scope.defaultLocNew = { public: true };
        }
        if(loc == $scope.nz){
            //$scope.NZBannerShow = true;
            $scope.nzActive = 'active btn-dark';
            $scope.btn = 'New Zealand';
            $scope.defaultLocNew = { nz: true };
        }
        if(loc == $scope.au){
            //$scope.AUBannerShow = true;
            $scope.auActive = 'active btn-dark';
            $scope.btn = 'Australia';
            $scope.defaultLocNew = { au: true };
        }  
        if(loc == $scope.sg){ 
            $scope.sgActive = 'active btn-dark';
            $scope.btn = 'Singapore';
            $scope.defaultLocNew = { sg: true };
        }  
        if(loc == $scope.my){ 
            $scope.myActive = 'active btn-dark';
            $scope.btn = 'Malaysia';
            $scope.defaultLocNew = { my: true };
        }  

        $scope.bannerNewForm.location =  $scope.defaultLocNew;
       // console.log(loc);
        $http({
                method: "post",
                url:  "<?php echo $angularPost; ?>",
                data: {  option: 2,  location: loc  } 
            }).then(function successCallback(getdata) { 
                 //console.log(getdata.data);   
                 $scope.publicBanner = getdata.data;
                 
                 if(loc == $scope.public){
                        $scope.formCondition = $scope.public;
                 }
                 if(loc == $scope.nz){
                        $scope.formCondition = $scope.nz;
                 }
                 if(loc == $scope.au){
                        $scope.formCondition = $scope.au;
                 }  
                 if(loc == $scope.sg){
                        $scope.formCondition = $scope.sg;
                 }  
                 if(loc == $scope.my){
                        $scope.formCondition = $scope.my;
                 }  
            }, function errorCallback(getdata) {
                        alert("Error updating the getdata");
        });    
  }

  $scope.editBannerForm = function(place){
       // console.log(place); 
        $scope.mainData = $scope.publicBanner;
        $scope.bannerLoc = place; 
        if(place ==  $scope.public){ 
            $scope.bannerMsg = 'Public banner updated successfuly!'; 
        }
        if(place ==  $scope.nz){ 
            $scope.bannerMsg = 'New Zealand banner updated successfuly!'; 
        }
        if(place ==  $scope.au){ 
            $scope.bannerMsg = 'Australia banner updated successfuly!'; 
        }
        if(place ==  $scope.sg){ 
            $scope.bannerMsg = 'Singapore banner updated successfuly!'; 
        }
        if(place ==  $scope.my){ 
            $scope.bannerMsg = 'Malaysia banner updated successfuly!'; 
        }
        console.log(place);
         $http({
                method: "post",
                url:  "<?php echo $angularPost; ?>",
                data: {  option: 1, updateData: $scope.mainData, location: $scope.bannerLoc } 
            }).then(function successCallback(responseUpdate) { 
                console.log(responseUpdate.data);   
                if(responseUpdate.data.success == '1'){
                    $scope.success($scope.bannerMsg);        
                }else{
                    alert("Banner items cannot be empty!");
                }  
            }, function errorCallback(responseUpdate) {
                        alert("Error updating the dbanner");
        });           
                    
  }

  $scope.deleteBanner = function(id, location, filename, loc){
        if (confirm("Are you sure you want to delete  this banner?")) { 
             //console.log(id + "/" + location + "/" + filename + "/" + loc);
            $http({
                    method: "post",
                    url:  "<?php echo $angularPost; ?>",
                    data: {
                        id: id,
                        location: location,
                        filename: filename,
                        option: 3 
                    },
            }).then(function successCallback(responseDel) { 
                console.log(responseDel.data);
                if(responseDel.data == 'success'){
                    $scope.success('Image removed!'); 
                    $scope.activateBanner(loc);
                }
                 
            }, function errorCallback(responseDel) {
                alert("Error retrieving the responseDel");
            });  
        }
  }

  $scope.success = function(msg){
        var element = angular.element('#successModal'); 
        element.modal('show'); 
        $scope.successMsg = msg;
        $timeout(function() {
            element.modal('hide'); 
        }, 900);  
  }

  $scope.getFormPopupLocation = function(id, ind){
        
       $scope.popupFormLocation = id; 
       $scope.popupFormRow = ind; 
      // console.log($scope.popupFormLocation + $scope.popupFormRow);
  }

  $scope.putModalURLInput = function(vals){
      if($scope.popupFormLocation == 'formUrl'){
            $scope.bannerNewForm.url = vals;
      }else{
            var element = angular.element('#publicUrl'+ $scope.popupFormLocation); 
            element.val(vals); 
            $scope.publicBanner[$scope.popupFormRow].url = vals; 
      }
      
      var elementM = angular.element('#popOptionModal'); 
      $timeout(function() {
           elementM.modal('hide'); 
      }, 300); 
  }  
  

}]); // end controller


 
</script>

