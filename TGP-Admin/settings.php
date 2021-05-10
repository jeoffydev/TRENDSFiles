<?php
  //Get the TGP setup and logcheck
  if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
    header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
    die( header( 'location: /' ) ); 
 } 
  
  //Settings 
  $navUrl = '/TGP-Admin';

//Temporary direct DB to DEV in trends.nz
  if($_SERVER['SERVER_NAME'] == "localhost" ){
    $baseUrl = "http://" . $_SERVER['SERVER_NAME'].$navUrl;
    $devStuff = 1;
  }else{
    $baseUrl = "https://" . $_SERVER['SERVER_NAME'].$navUrl;
    $devStuff = 0;
  } 
 
   
   //Mysql table settings
    if($devStuff == 1) {
        $table = 1;
    }else{
        $table = 2;
    } 
 
    function getUserAdmin($userID){
        
        $res = array('letmein' => 0, 'results' => 0);
        $conn = Db::getInstance();   
        $req = $conn->prepare("SELECT userEmail,userID,userAcct,userSalt,userType,CustomerOnHold,CustomerName,userAccess  FROM  userData LEFT OUTER JOIN customerData ON customerData.CustomerNumber = userData.userAcct WHERE userID='".$userID."' AND userAcct = '10105'  ");  
        $req->execute();
        $results =  $req->fetch();

        if($results){ 
          $res = array('letmein' => 1, 'results' => $results );
          
        }
        return $res;
    }
    
     
?>