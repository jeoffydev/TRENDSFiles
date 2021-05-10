<?php

    $sql= getProducts($table); 
     
    $json_data=array();
    foreach($sql as $rec)//foreach loop  
    {  
      $json_array['Prim']=$rec['Prim']; 
      $json_array['Code']=$rec['Code'];  
      $json_array['Name']=clean($rec['Name']); 
      if($rec['Active'] == 1){
          $Active = 'Active';
      }else{
         $Active = 'Inactive';
      }
      $json_array['Active'] = $Active;
      array_push($json_data,$json_array);
    } 
    $my_images = json_encode($json_data,JSON_PRETTY_PRINT); 
    
    function clean($string) { 
        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
   }
?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",function($scope, $http, $httpParamSerializerJQLike, $timeout){
  $scope.query = {}
  $scope.queryBy = '$'
  $scope.products = <?php echo $my_images; ?>;
  $scope.orderProp="Code";  
  //Get the Data ID 

  $scope.editImagesActive = false;
  $scope.selectImageItem = function(id) {    
            $http({
                method: "post",
                url:  "<?php echo $angularPost; ?>",
                data: {
                    id: id,
                    option: 1, 
                },
            }).then(function successCallback(response) { 
                console.log(response.data.Code);
                //console.log(response.data.ImageCountNew);
                $scope.editImagesActive = true;
                $scope.editImages = response.data;
                $scope.editImageForm = {};
                //Next uplaod will be this number
                $scope.editImagePrim = response.data.Prim;
                $scope.editImageID = id;
                $scope.editImageCode = response.data.Code;
                $scope.editImageCountNew = response.data.ImageCountNew;  
                $scope.editImageCountOrig = response.data.ImageCount; 
                $scope.uploadImage;
                $scope.editImageForm.selectImageToReplace = 'main';
                $scope.productStocks = response.data.productStocks; 
                $scope.coloursSelects = response.data.coloursSelects; 

                console.log(response.data.productStocks);

               

                $scope.random = Math.random();
                


                $scope.form = [];
                $scope.files = []; 
                $scope.uploadFile = function(){   

                    console.log($scope.editImageForm.FormFile);
                    var form_data = new FormData();  
                    console.log(form_data);
                    angular.forEach($scope.files, function(file){  
                            form_data.append('addfiles', file);  
                            form_data.append("option", 2);
                            form_data.append("editImageCountNew", $scope.editImageCountNew); 
                            form_data.append("editImageID", $scope.editImageID); 
                            form_data.append("editImageCode", $scope.editImageCode);  
                            form_data.append("formCondition", $scope.editImageForm.FormFile);
                            form_data.append("editImagePrim", $scope.editImagePrim);

                    });  
                    $http.post('<?php echo $angularPost; ?>', form_data,  
                    {  
                            transformRequest: angular.identity,  
                            headers: {'Content-Type': undefined,'Process-Data': false}  
                    }).then(function successCallback(responseImage) { 
                         console.log(responseImage.data);
                         if(responseImage.data == 0){
                             alert("Please upload JPEG file only");
                             return;
                         }
                         $scope.selectImageItem($scope.editImagePrim); 
                        var element = angular.element('#successModal'); 
                        element.modal('show'); 
                        $scope.successMsg = 'Image Uploaded';
                        $timeout(function() {
                            element.modal('hide'); 
                        }, 900);

                    }, function errorCallback(responseImage) {
                        alert("Error retrieving the data");
                    }); 
                }  
                
                
                /* $scope.imageFormSubmitted = function(){
                     
                    var filex = document.getElementById("file");
                    var formdata = new FormData(); 
					var photo = document.getElementById("file"); 
                    var file = photo.files[0]; 
                     

                   
                     $http({
                        method: "post",
                        url:  "<?php // echo $angularPost; ?>",
                        data:  formdata,
                        headers: {'Content-Type': undefined,'Process-Data': false}
                    }).then(function successCallback(responseImage) { 
                         console.log(responseImage.data);
                    }, function errorCallback(responseImage) {
                        alert("Error retrieving the data");
                    });  
                                
                } */




            }, function errorCallback(response) {
                alert("Error retrieving the data");
            });  

  }  

  $scope.selectedClass = '';

  $scope.selectReplace = function(ind){
      console.log(ind);
       
      var thisClass = angular.element( document.querySelector('#card' + ind) );

      if(thisClass){
            thisClass.addClass('selected-card'); 
      } 
      //thisClass.css('border', '1px solid #ff0000');   

      //var item = $scope.selectedClass[ind];
      
      //All
     // var removeClassReset = angular.element( document.querySelector('.remove-selected') );
      /*var  removeClassReset = angular.element( document.querySelector('.remove-selected') );

      var thisClassReset= angular.element( document.querySelector('.card') ); 
      thisClassReset.removeClass('selected-card'); 
      removeClassReset.removeClass('show');
      removeClassReset.addClass('hide'); 

      var thisClass = angular.element( document.querySelector('#card' + ind) );
      var removeClassActive = angular.element( document.querySelector('.remove-selected' + ind) );

      /* thisClass.addClass('selected-card'); 
      removeClassActive.removeClass('hide');
      removeClassActive.addClass('show'); */

     // $scope.selectedClass = 'selected-card'
  }

$scope.selectDefault = function(){
    return true;   
}

$scope.removeImage = function (Prim, Code, Image){

    if (confirm("Are you sure you want to delete " + Code + '-' + Image + ".jpg ?")) { 
        $http({
                    method: "post",
                    url:  "<?php echo $angularPost; ?>",
                    data: {
                        Prim: Prim,
                        Image: Image,
                        Code: Code,
                        option: 3, 
                    },
        }).then(function successCallback(responseDel) { 
            console.log(responseDel.data);
            if(responseDel.data == 'success'){
                $scope.selectImageItem(Prim); 
            }

        }, function errorCallback(responseDel) {
            alert("Error retrieving the data");
        }); 
    }     

}


 

$scope.stockcodeChange = function(stock, imgNum, code, primId){
    console.log(stock + '-' + imgNum + '-' + code);  
    

        $http({
                method: "post",
                url:  "<?php echo $angularPost; ?>",
                data: {
                    stock: stock,
                    imgNum: imgNum,
                    code: code,
                    option: 4, 
                },
        }).then(function successCallback(response) { 
            console.log(response.data);
            
            var element = angular.element('#successModal'); 
            var elementStock = angular.element('.allStockModel'); 
            elementStock.modal('hide');
                element.modal('show'); 
                $scope.successMsg = 'Stock saved!';
                $timeout(function() {
                            element.modal('hide');  
                            $scope.selectImageItem(primId); 
                }, 900);
                
                 
               
        }, function errorCallback(response) {
            alert("Error retrieving the data" + response.data);
        });  
    
}



$scope.stockcolourChange = function(colour, imgNum, code, primId){
       console.log(colour + '-' + imgNum + '-' + code); 
       
            $http({
                    method: "post",
                    url:  "<?php echo $angularPost; ?>",
                    data: {
                        colour: colour,
                        imgNum: imgNum,
                        code: code,
                        option: 5, 
                    },
            }).then(function successCallback(response) { 
                console.log(response.data);
                var element = angular.element('#successModal'); 
                var elementStock = angular.element('.allStockModel'); 
                elementStock.modal('hide');
                    element.modal('show'); 
                    $scope.successMsg = 'Stock saved!';
                    $timeout(function() {
                                element.modal('hide'); 
                                $scope.selectImageItem(primId); 
                    }, 900);
            }, function errorCallback(response) {
                alert("Error retrieving the data" + response.data);
            }); 
         
 }   


}); // end controller



 
 
</script>

