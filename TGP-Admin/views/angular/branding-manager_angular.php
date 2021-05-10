
<?php

$sql= getProducts($table); 
 
$json_data=array();
foreach($sql as $rec)//foreach loop  
{  
  $json_array['Prim']=$rec['Prim']; 
  $json_array['Code']=$rec['Code'];  
  $json_array['Name']=clean($rec['Name']); 
  $json_array['featuredItem']=$rec['featuredItem']; 
  if($rec['Active'] == 1){
      $Active = 'Active';
  }else{
     $Active = 'Inactive';
  }
  $json_array['Active'] = $Active;
  array_push($json_data,$json_array);
} 
$my_products = json_encode($json_data,JSON_PRETTY_PRINT); 

$randNum = rand();

function clean($string) { 
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}
?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",  ['$scope', '$http',  'Upload', '$timeout',  function($scope, $http, Upload, $timeout){  

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.products = <?php echo $my_products; ?>; 
  $scope.orderProp="Code";   
  $scope.fileNull = 1;
  $scope.emptyPDF = "Please upload a PDF file!";
  $scope.sizePDF = "Please upload not more than 2MB!";
  $scope.existPDF = "PDF file already exist!";
  $scope.wrongCode = "Filename doesn't match the item code"; 
  $scope.existOverwrite = "New PDF file for the existing wire being uploaded";
  $scope.random = <?php echo $randNum; ?>;
$scope.selectItem = function(id, itemName) {     
     
     $http({
        method: "post",
        url:  "<?php  echo $angularPost; ?>",
        data: {
            id: id,
            option: 1, 
        },
    }).then(function successCallback(response) { 
           console.log(response.data.length);  
           $scope.resultPDFCount = response.data.length; 
           $scope.brandingCode = id;
           $scope.itemName = itemName;
           $scope.pdfBranding = response.data;
           $scope.editBranding = {};
            
            $scope.uploadPic = function(file, itemCode) {
               //console.log(file);
               var itemCode = itemCode || null;

               if(file){ 
                   file.upload = Upload.upload({
                        url: '<?php echo $angularPost; ?>',
                        data: {options: 3, file: file, itemCode: itemCode},
                    });

                    file.upload.then(function (response ) {  
                        console.log(response.data);
                        if(response.data.validate === 0){
                            alert(response.data.filename + " - " + $scope.emptyPDF);    
                            return;
                        }
                        if(response.data.validate === 1){
                            alert(response.data.filename + " - " + $scope.sizePDF); 
                             return;
                        }  

                        if(response.data.validate === 2){
                            alert(response.data.filename + " - " + $scope.existPDF); 
                            return;
                        }   
                        if(response.data.validate === 4){
                            alert(response.data.filename + " - " + $scope.wrongCode); 
                            return;
                        }   

                        if(response.data.validate === 3){
                            console.log(response.data.filename); 
                            console.log(file);
                            //console.log(id + " Sample here " + itemName); 
                            //angular.element(".tab-pane").removeClass('active show'); 
                            //angular.element(".nav-link").removeClass('active show');

                            //angular.element("#main-tab").addClass(' active show '); 
                            //angular.element("#main").addClass(' active show ');  
                            angular.element("#removeTr" + itemCode).css('display', 'none'); 
                            //$scope.selectWithoutWires(1);
                            $scope.selectWithoutWires(1);
                            $scope.selectItem(id, itemName);
                            
                            
                        } 
                       
                    }, function (response) {
                    if (response.status > 0)
                        $scope.errorMsg = response.status + ': ' + response.data;
                    });

               }
            }
            

            $scope.buttonUpload = false;

            $scope.clickUpload = function(){
                $scope.buttonUpload = true;
            }
           
            $scope.arrFileNameExist = false;
            $scope.uploadMultiple = function (files) { 
                 
                var arr = []; 
                if (files && files.length) {
                     
                  
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                         console.log(file);    
                            
                        if(file){ 
                                file.upload = Upload.upload({
                                    url: '<?php echo $angularPost; ?>',
                                    data: {options: 7, file: file, id: $scope.brandingCode },
                                });

                                file.upload.then(function (response ) {  
                                    //console.log(response.data.validate);
                                
                                    if(response.data.validate === 0){
                                        alert(response.data.filename + " - " + $scope.emptyPDF);    
                                        return;
                                    }
                                    if(response.data.validate === 1){
                                        alert(response.data.filename + " - " + $scope.sizePDF); 
                                        return;
                                    }  

                                    if(response.data.validate === 2){
                                        alert(response.data.filename + " - " + $scope.existPDF); 
                                        return;
                                    }   

                                    if(response.data.validate === 5){
                                        //alert(response.data.filename + " - " + $scope.existOverwrite); 
                                        console.log("eto ang 5 " + response.data.filename); 
                                        $scope.arrFileNameExist = true;
                                        $scope.random = $scope.random + 1
                                        arr.push(response.data.filename);
                                        $scope.selectItem($scope.brandingCode, $scope.itemName);
                                        
                                    }   

                                     
                                     
                                    if(response.data.validate === 3){
                                        console.log(response.data.filename); 
                                        $scope.arrFileNameExist = true;
                                        arr.push(response.data.filename);
                                        $scope.selectItem($scope.brandingCode, $scope.itemName);
                                        
                                    } 
                                
                                }, function (response) {
                                if (response.status > 0)
                                    $scope.errorMsg = response.status + ': ' + response.data;
                                }); 
                        }  
 
                    }  
                    $scope.arrFileName = arr;
                }
            };
            
            $scope.deleteBranding = function(code, filename){
                if (confirm("Are you sure you want to delete this branding template?")) { 
                    //console.log(code + filename);
                    $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: {code: code, filename: filename, options: 4 }

                    }).then(function successCallback(response) {  
                         console.log(response.data);
                         $scope.selectItem(id, itemName);   
                    }, function errorCallback(response) {
                        alert("Error retrieving the data");
                    });  
                }
            }
            
            $scope.loading =  false;
            $scope.btndark1 = false;
            $scope.btndark2 = false;
            $scope.selectWithoutWires = function(stat){
                //console.log("Testing " + stat);
                $scope.loading =  true;
                $scope.loading = 'Loading the data...';
                $scope.itemsWithoutWires = '';

                if(stat == 1){
                    $scope.btndark1 = true;
                    $scope.btndark2 = false;
                }
                if(stat == 0){
                    $scope.btndark2 = true;
                    $scope.btndark1 = false;
                }

                $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: { stat: stat, options: 5 }

                }).then(function successCallback(response) {  
                        
                        //console.log(response.data); 
                        
                        
                        if(response.data){   
                            $scope.itemsWithoutWires = response.data;  
                            $scope.itemPaginates = response.data;
                            $timeout(function() {
                                $scope.loading =  false;
                            }, 900); 
                        }

                }, function errorCallback(response) {
                        alert("Error retrieving the data");
                });  
            }

            $scope.fileSized = function(field, stat){
                //console.log(stat); 
                //console.log(field); 
                $http({
                        method: "post",
                        url:  "<?php   echo $angularPost; ?>",
                        data: { stat: stat, field: field, options: 6 }

                }).then(function successCallback(response) {  
                    //console.log(response.data); 
                    $scope.fileSizeResult = response.data;
                }, function errorCallback(response) {
                        alert("Error retrieving the data");
                });  

            }
             
 

    }, function errorCallback(response) {
          alert("Error retrieving the data");
    });  
 

}   


 $scope.checkPDF = function(file, ids) {
               var ids = ids || null;
               
               //console.log(file);
               if(file){ 
                   file.upload = Upload.upload({
                        url: '<?php echo $angularPost; ?>',
                        data: {options: 2, file: file},
                    });

                    file.upload.then(function (response ) {  
                       // console.log(response.data);
                       
                        if(response.data === "0"){
                            alert($scope.emptyPDF);
                            angular.element("input#mainfileUploads").val(null);   
                            $scope.picFileSubmit = false; 
                            
                        }
                        if(response.data === "1"){
                            alert($scope.sizePDF);
                            angular.element("input#mainfileUploads").val(null);   
                            $scope.picFileSubmit = false;  
                            
                        }  

                        if(response.data === "2"){
                            alert($scope.existPDF);
                            angular.element("input#mainfileUploads").val(null);   
                            $scope.picFileSubmit = false; 
                             
                        }   
                        if(response.data === "3"){
                            $scope.picFileSubmit = true; 
                            $scope.fileNull = 0;  
                        }

                        
                        
                       
                    }, function (response) {
                    if (response.status > 0)
                        $scope.errorMsg = response.status + ': ' + response.data;
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


}]); // end controller


 
</script>

