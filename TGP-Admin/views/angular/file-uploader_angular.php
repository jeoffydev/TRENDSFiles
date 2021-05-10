
<?php
 
$sql= getProducts($table); 
 
 
        $json_data=array();
        $i = 1;
        $serverPath = $_SERVER['DOCUMENT_ROOT']; 
        $pathUrl = $serverPath.'/Downloads-folder/'; 
        chdir($pathUrl); 
        foreach(glob("*.{gif,png,jpg,jpeg,pdf,ai,cdr,zip,rar,7z,eps,GIF,PNG,JPG,JPEG,PDF,AI,CDR,ZIP,RAR,7Z,EPS}", GLOB_BRACE) as $file) { 
            
           array_push($json_data,$file); 
           $i++;
        }   
        $downloadsFolderFile = json_encode($json_data,JSON_PRETTY_PRINT); 
 
 

?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",  ['$scope', '$http',  'Upload', '$timeout', '$window',  function($scope, $http, Upload, $timeout, $window){  
 
    $scope.FilesUploaded = <?php echo $downloadsFolderFile; ?>; 
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
                                     //console.log(response.data);

                                     if(response.data == 1){
                                        $timeout(function() {
                                            $window.location.reload();
                                        }, 600);  
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
             


}]); // end controller


 
</script>

