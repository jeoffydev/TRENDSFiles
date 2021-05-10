
<?php
 
$sql= getProducts($table); 
 
 
        $json_data=array();
        $i = 1;
        $serverPath = $_SERVER['DOCUMENT_ROOT']; 
        $pathUrl = $serverPath.'/Downloads-folder/email/'; 
        chdir($pathUrl); 
        foreach(glob("*.{gif,png,jpg,jpeg,GIF,PNG,JPG,JPEG}", GLOB_BRACE) as $file) { 
            
           array_push($json_data,$file); 
           $i++;
        }   
        $downloadsFolderFile = json_encode($json_data,JSON_PRETTY_PRINT); 
 
        $json = file_get_contents($pathUrl.'emailbanner.json');  
        $json_emailbanner = json_decode($json,true); 
        
        if($json_emailbanner){
            $emailBannerUrlvalue = $json_emailbanner['url'];
        }else{
            $emailBannerUrlvalue = 'home';
        }

?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window',  function($scope, $http, Upload, $timeout, $window){  
 
    $scope.FilesUploaded = <?php echo $downloadsFolderFile; ?>; 
    $scope.emailBannerUrl = '<?php echo $emailBannerUrlvalue; ?>';
    $scope.success = false;
    $scope.randomNumber = Math.floor((Math.random() * 100) + 1) + Date.now(); 
    $scope.uploadFile = function (files) { 
                 
                
                 if (files && files.length) {
                      
                   
                     for (var i = 0; i < files.length; i++) {
                         var file = files[i];
                          //console.log(file);    
                             
                         if(file){ 
                                 file.upload = Upload.upload({
                                     url: '<?php echo $angularPost; ?>',
                                     data: {options: 1, file: file  },
                                 });
 
                                 file.upload.then(function (response ) {  
                                      
                                     

                                     if(response.data == 1){
                                        $timeout(function() {
                                            $window.location.reload();
                                        }, 600);  
                                     }else if(response.data == 2){
                                         alert("Sorry, only JPEG file is allowed!");
                                     }else{
                                         alert("Sorry, file is more than 6MB!");
                                     }
                                 
                                      
                                 
                                 }, function (response) {
                                 if (response.status > 0)
                                    console.log("Cannot upload files");
                                 }); 
                         }  
  
                     }  
                     
                 }
    };

    $scope.removeThisFile = function(fileName){
        if (confirm("Are you sure you want to delete this file?")) { 
            $http({
                method: "post",
                url:  '<?php echo $angularPost; ?>',
                data: {
                    fileName: fileName, 
                    option: 2, 
                },
            }).then(function successCallback(response) { 
                   
                    if(response.data == 1){
                        $timeout(function() {
                            $window.location.reload();
                        }, 600);  
                    }
                 }, function errorCallback(response) {
                    alert("Error removing the file"); 
            });   
        }
    }

    $scope.submitEmailURL = function(url){
           
        if(url){
            $http({
                method: "post",
                url:  '<?php echo $angularPost; ?>',
                data: {
                    url: url, 
                    option: 3, 
                },
            }).then(function successCallback(response) { 
                   
                     
                     if(response.data == 1){
                        $scope.success = true;
                        $timeout(function() {
                            $scope.success = false;
                        }, 1500); 
                     }
                       

                 }, function errorCallback(response) {
                    alert("Error saving URL"); 
            }); 
        } 
    }
             


}]); // end controller


 
</script>

