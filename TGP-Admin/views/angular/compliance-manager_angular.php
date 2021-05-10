
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

$scope.selectItem = function(id, itemName) {     
     //Disabled and nulled the File input
     angular.element("input#mainfileUpload").val(null); 

      

     $http({
        method: "post",
        url:  "<?php  echo $angularPost; ?>",
        data: {
            id: id,
            option: 1, 
        },
    }).then(function successCallback(response) { 
           //console.log(response.data.length);  
           $scope.resultPDFCount = response.data.length; 
           $scope.pdfCode = id;
           $scope.itemName = itemName;
           $scope.pdfCompliance = response.data;
           $scope.editCompliance = {};
           $scope.editCompliance.PDFName;
           $scope.editCompliance.PDFDesc;
           $scope.editCompliance.pdfFormFile; 
           $scope.editCompliance.option = 2;
           $scope.editCompliance.pdfFormFile;
           $scope.picFileSubmit = false;


          
           
           $scope.uploadPic = function(file, fileNull) {
                //var file = file || null;
               // console.log(fileNull  + " filenull");
                if(fileNull == 1){
                    file = null; 
                }
                //console.log(file);

                var PDFName = $scope.editCompliance.PDFName || null;
                var PDFDesc = $scope.editCompliance.PDFDesc || null;
                
               // console.log(PDFName + " / " + PDFDesc );
               
               if(file){
                    file.upload = Upload.upload({
                        url: '<?php echo $angularPost; ?>',
                        data: {options: 2, PDFName:  PDFName, PDFDesc: PDFDesc, PDFCode: $scope.pdfCode,   file: file},
                    });

                    file.upload.then(function (response) {  
                        //console.log("Here 1");
                        $scope.editCompliance.PDFName = null;
                        $scope.editCompliance.PDFDesc = null;   
                        //console.log(response.data);
                        angular.element("input#mainfileUpload").val(null); 
                        $scope.picFileSubmit = false;
                        $scope.success('New compliance saved');
                        $scope.selectItem(id, itemName);

                    }, function (response) {
                    if (response.status > 0)
                        $scope.errorMsg = response.status + ': ' + response.data;
                    });
               }else{
                   
                    $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: {options: 4, PDFName:  PDFName, PDFDesc: PDFDesc, PDFCode: $scope.pdfCode }

                    }).then(function successCallback(response) { 
                        //console.log("Here 2");
                        $scope.editCompliance.PDFName = null;
                        $scope.editCompliance.PDFDesc = null;   
                        //console.log(response.data);
                        angular.element("input#mainfileUpload").val(null); 
                        $scope.picFileSubmit = false;
                        $scope.success('New compliance saved');
                        $scope.selectItem(id, itemName);

                    }, function errorCallback(response) {
                        alert("Error retrieving the data");
                    });  
               }  
                
           }

           


            $scope.changePDFUpload = function(file,  pdfID, pdfFilename) {
                var pdfFilename = pdfFilename || null;  
                //validate
                //console.log(file);
               if(file){ 
                   file.upload = Upload.upload({
                        url: '<?php echo $angularPost; ?>',
                        data: {options: 3, file: file},
                    });

                    file.upload.then(function (response ) {  
                       // console.log(response.data);
                        if(response.data === "0"){
                           
                            alert($scope.emptyPDF); 
                            angular.element("input.changefileUpload").val(null);   
                            
                        }
                        if(response.data === "1"){
                            alert($scope.sizePDF); 
                            angular.element("input.changefileUpload").val(null);   
                            
                        }  

                        if(response.data === "2"){
                            alert($scope.existPDF); 
                            angular.element("input.changefileUpload").val(null);   
                             
                        }   
                        if(response.data === "3"){
                           // console.log(file);
                           // console.log(" / " + pdfID + " / " + pdfFilename);

                            file.upload = Upload.upload({
                                url: '<?php echo $angularPost; ?>',
                                data: {options: 8, pdfFilename: pdfFilename, pdfID:pdfID,  file: file},
                            });

                            file.upload.then(function (response) {  
                              //  console.log(response.data); 
                                $scope.selectItem(id, itemName);

                            }, function (response) {
                            if (response.status > 0)
                                $scope.errorMsg = response.status + ': ' + response.data;
                            });


                        } 
                       
                    }, function (response) {
                    if (response.status > 0)
                        $scope.errorMsg = response.status + ': ' + response.data;
                    });

               } 
                 
               
            }

           $scope.sortableOptions = {
                update: function(e, ui) {
                   // console.log("Order changed"); 
                   // console.log($scope.pdfCompliance);
                    $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: {options: 5,  PDFCode: $scope.pdfCode, PDFOrder: $scope.pdfCompliance }

                    }).then(function successCallback(response) { 
                        //console.log(response.data);
                        $scope.success('Sorting updated');
                    }, function errorCallback(response) {
                        alert("Error retrieving the data");
                    });  

                } 
            };

            $scope.updatePDFCompliance = function(pdfID, field, pdfValue){
                if(field =="standard"){
                    if(pdfValue.length < 1){
                        alert("Standard is required");
                        $scope.selectItem(id, itemName);
                        return;
                    }
                }
                //console.log(pdfID + " / " + field + " / " + pdfValue);
                    $http({
                            method: "post",
                            url:  "<?php  echo $angularPost; ?>",
                            data: {options: 6,  pdfID: pdfID, field: field, pdfValue: pdfValue }

                    }).then(function successCallback(response) { 
                            console.log(response.data); 
                    }, function errorCallback(response) {
                            alert("Error retrieving the data");
                    });  
            }
            
            //Delete uploaded PDF
            $scope.deleteSelectedPDF = function(pdfID, pdfFileName){
                //console.log(pdfID + "/" + pdfFileName);
                if (confirm("Are you sure you want to delete  this PDF?")) { 
                    $http({
                            method: "post",
                            url:  "<?php  echo $angularPost; ?>",
                            data: {options: 7,  pdfID: pdfID, pdfFileName: pdfFileName }

                    }).then(function successCallback(response) { 
                            //console.log(response.data); 
                            $scope.selectItem(id, itemName);
                    }, function errorCallback(response) {
                            alert("Error retrieving the data");
                    });  
                }
            }

            
            $scope.deleteCompliance = function(pdfids, pdfFile){
                var pdfFile = pdfFile || null;
                if (confirm("Are you sure you want to delete  this Compliance?")) { 
                               // console.log(pdfids + " / " + pdfFile);
                                $http({
                                        method: "post",
                                        url:  "<?php  echo $angularPost; ?>",
                                        data: {options: 9,  pdfids: pdfids, pdfFile: pdfFile }

                                }).then(function successCallback(response) { 
                                       // console.log(response.data); 
                                        $scope.selectItem(id, itemName);
                                        
                                }, function errorCallback(response) {
                                        alert("Error retrieving the data");
                                });  
                }
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
                        data: {options: 3, file: file},
                    });

                    file.upload.then(function (response ) {  
                       // console.log(response.data);
                       
                        if(response.data === "0"){
                            alert($scope.emptyPDF);
                            angular.element("input#mainfileUpload").val(null);  
                            angular.element("input.changefileUpload").val(null);  
                            $scope.picFileSubmit = false; 
                            
                        }
                        if(response.data === "1"){
                            alert($scope.sizePDF);
                            angular.element("input#mainfileUpload").val(null); 
                            angular.element("input.changefileUpload").val(null);  
                            $scope.picFileSubmit = false;  
                            
                        }  

                        if(response.data === "2"){
                            alert($scope.existPDF);
                            angular.element("input#mainfileUpload").val(null); 
                            angular.element("input.changefileUpload").val(null);  
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

