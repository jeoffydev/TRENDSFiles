
<?php

$sql= getProducts($table); 
 
$json_data=array();
foreach($sql as $rec)//foreach loop  
{  
    
    $getDate = $rec['departDunedin']; 
    $arrive =  dateCompare($getDate, 1); 

    $json_array['id']=$rec['id']; 
    $json_array['HawbReference']=$rec['HawbReference']; 
    $json_array['headport']=$rec['headport'];  
    $json_array['departDunedin']=$rec['departDunedin']; 
    $json_array['arriveDestination']=$rec['arriveDestination'];
    $json_array['arrive'] =  $arrive;   

    if($rec['arriveDestination'] != null || $rec['arriveDestination'] != ""){ 
        
        $cut = substr($rec['arriveDestination'], 0, 10);
        list($res1, $res2, $res3) = explode("/", $cut);  
        $arriveDest =  $res1. '-' .$res2.'-' .$res3;

        if(strtotime($arriveDest) < strtotime('-7 days')) { 
            $json_array['status'] =  '0';  
        }else{  
            $json_array['status'] =  '1'; 
        } 

        
    }else{   
        $json_array['status'] =  '1'; 
    }    
    array_push($json_data,$json_array);
} 




$my_products = json_encode($json_data,JSON_PRETTY_PRINT); 

function clean($string) { 
    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}


function  dateCompare($getDate, $opt=null){ 
      
    date_default_timezone_set('NZ');
    $day = date("d");
    $month = date("m");
    $year = date("Y"); 
    $today = date("d-m-Y");
    if($opt == 1){
          $time = '9:00AM';
    }else{
          $time = '';
    }
    $getDate = str_replace('/', "-", $getDate);  
    
    if(strtotime($today) > strtotime($getDate)){  
           list($t1, $t2, $t3) = explode("-", $today); 
           list($d1, $d2, $d3) = explode("-", $getDate); 
           
           $arrayMos = array('04', '06', '09', '11');
           $arrayMos2 = array('02'); 

          if(in_array($d2, $arrayMos) && ($d1 == "30")){
                $d2 = (int)$d2;
                $d2new = $d2 + 1;
                $arrive =  '01/'.$d2new.'/'.$d3. ' '.$time; 
              
          }elseif(in_array($d2, $arrayMos2) && ($d1 == "28") ){
                $d2 = (int)$d2;
                $d2new = $d2 + 1;
                $arrive =  '01/'.$d2new.'/'.$d3. ' '.$time; 
                
          }else{ 
                $d1 = (int)$d1;
                $d1new = $d1 + 1;
                if($d1  ==  "31" ){
                      $d1new = '01';
                      if($d2 != 12){
                            $d2 = $d2 + 1;
                      }
                      if($d2 == 12){
                            $d2 = '01';
                      }   
                }
                $arrive = $d1new.'/'.$d2.'/'.$d3. ' '.$time; 
          }  

     }else{
           $arrive = null;
     }   
     return $arrive;
}


?>

<script>
// Define the `phonecatApp` module

 
tgpApp.controller("editCtrl",  ['$scope', '$http',  'Upload', '$timeout',  function($scope, $http, Upload, $timeout){  

  $scope.query = {}
  $scope.queryBy = '$'
  $scope.products = <?php echo $my_products; ?>; 
  $scope.orderProp="HawbReference";    


    $scope.formData = {};
    $scope.formUpdate = {};
    $scope.formBtn = true;
    $scope.formHawb = 0;
    $scope.formDate = 0;
    $scope.InputClass = 'hideInput';
    $scope.exists = false;
    $scope.existsPort = false;
    $scope.finHawb = 0;
    $scope.finDate = 0;
    $scope.successCheck = false;

    $scope.addNewDhlForm = function(){
                    console.log($scope.formData);
                    $scope.formData['option'] = 3;
                    $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: $scope.formData
                    }).then(function successCallback(responseInsert) { 

                        console.log(responseInsert.data + " eto dito");
                        if(responseInsert.data == '1'){
                            $scope.refreshList();
                        }

                    }, function errorCallback(responseInsert) {
                                alert("Error retrieving the data from responseCheck");
                    });     
         
    }
 

     $scope.checkValidateHawb = function(hawb, dates, headport){ 
            $scope.existsMsg = '';
            $scope.exists = false;

             
            
           if(hawb == null || hawb == "" || hawb == 0){
                   $scope.formHawb = 0; 
                   $scope.validate($scope.formHawb, $scope.checkValidateDate(dates), headport);
           }else{

                    $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: { hawb: hawb, option: 2 }
                    }).then(function successCallback(responseCheck) { 

                                    //console.log(responseCheck.data + " & " + hawb )  
                                            if(responseCheck.data == 1){
                                                $scope.formHawb = 0;
                                                $scope.exists = true;
                                                $scope.existsMsg = 'Hawb Reference already exist';
                                            }else{
                                                $scope.formHawb = 1;
                                                $scope.exists = false;
                                                $scope.existsMsg = '';
                                            }  
                                            $scope.validate($scope.formHawb, $scope.checkValidateDate(dates), headport);

                    }, function errorCallback(responseCheck) {
                                alert("Error retrieving the data from responseCheck");
                    });     

           } 

           
     }   

    $scope.checkValidateDate = function(newDate){ 
           
            var date_regex = /^(0[1-9]|1\d|2\d|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/ ;
            if((date_regex.test(newDate)))
            {
                $scope.formDate = 1;
            }else{
                $scope.formDate = 0;
            }   
            return  $scope.formDate;
    }

  /*
    $scope.HawbResult = function(res){
        var res  = null || res;
        $scope.finHawb = res;
        console.log("Hawb dito - " + $scope.finHawb);
        $scope.validate($scope.finHawb)
    } 

    $scope.dateResult = function(res){
        var res  = null || res;
        $scope.finDate = res;

        $scope.validate($scope.finHawb, $scope.finDate)
    } 

  $scope.$watch("formData", function(){
        console.log($scope.finHawb + " / " + $scope.finDate);
        $scope.validate($scope.finHawb, $scope.finDate);
    }, true); */

 
    $scope.validate = function (formHawbs, formDates, formHeadports){ 
        var formHawbs  = null || formHawbs;
        var formDates  = null || formDates;
        var formHeadports = null || formHeadports;

        if(formHeadports){ 
            formHeadports = 1;
            $scope.existsPort = true;
            $scope.existsMsgPort = 'Headport is required';
        }else{
            formHeadports = 0;
            $scope.existsPort = false;
            $scope.existsMsgPort = '';
        }  
        
        console.log(formHawbs + " / " + formDates);

        if(formHawbs == 1 && formDates == 1 && formHeadports == 1){
            $scope.formBtn = false; 
        }else{
            $scope.formBtn = true; 
        } 
    }

    $scope.refreshList = function(){ 
        location.reload();
    }
    
 

    $scope.openModal = function(id, arrive){ 
                $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: {id: id, arrive: arrive, option: 1}
                }).then(function successCallback(responseUpdate) { 

                            console.log(responseUpdate.data)
                            $scope.formUpdate = responseUpdate.data;
                            var element = angular.element('#editModal'); 
                            element.modal('show'); 
 
                }, function errorCallback(responseUpdate) {
                            alert("Error retrieving the data from responseUpdate");
                });   
    }
    
    $scope.deleteDHL = function(id){
        if (confirm("Are you sure you want to delete this Hawb Reference?")) {  
                $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: {id: id, option: 4}
                }).then(function successCallback(responseDelete) { 

                             if(responseDelete.data == '1'){
                                    $scope.refreshList();
                             } 
                }, function errorCallback(responseDelete) {
                            alert("Error retrieving the data from responseDelete");
                });  
        }
    }

    $scope.updateDhlForm = function(id){
        console.log($scope.formUpdate);
        console.log(id);
        $scope.formUpdate['option'] = 5;
        $scope.formUpdate['ids'] = id;
                $http({
                        method: "post",
                        url:  "<?php  echo $angularPost; ?>",
                        data: $scope.formUpdate
                }).then(function successCallback(responseUpdateHawb) { 

                            console.log(responseUpdateHawb.data);
                            if(responseUpdateHawb.data == '1'){
                                    $scope.successCheck = true;
                                    $timeout(function() {
                                        $scope.successCheck = false;
                                    }, 1000);
                            }  
 
                }, function errorCallback(responseUpdateHawb) {
                            alert("Error retrieving the data from responseUpdateHawb");
                });   
    }


    /*
    $scope.showEdit = function(hawbID){
        console.log(hawbID);
        var element1 = angular.element('.traceEdit');
        element1.removeClass('showInput');  
  

         var element2 = angular.element('.spanhide');
        element2.addClass('showInput'); 

        var element3 = angular.element('.spanhide' + hawbID);
        element3.addClass('hideInput');  

        var element3a = angular.element('.spanhide' + hawbID);
        element3a.removeClass('showInput');  


        var element4 = angular.element('.traceEdit' + hawbID);
        element4.removeClass('showInput');  
        element4.addClass('showInput');    
        
    } */

 

}]); // end controller


 
</script>

