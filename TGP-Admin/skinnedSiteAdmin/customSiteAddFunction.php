 
<?php 
include("../jeoffyFunction.php");
include_once("Class/Skinned.php");  
$jeof = new JeofClass();  
$conn =  $jeof->DB(); 
$skinned = new Skinned();  
session_start(); 
$rootUrl =  url();
$rpUrl = '/reset-user';


include_once("../functions.php");
include_once('lib/swift_required.php');
 
 if($_POST['option']==0){
       $data = array(
            'customsiteID' => $_POST['siteid'],
            'skinnedUserEmail' => $_POST['email'],
            'skinnedUserName' => $_POST['fname'],
            'skinnedCustomerNumber' => $_POST['cn'],
            'skinnedUserCompany' => $_POST['company'],
       ); 
       $resultSkinned = $skinned->insertSkinnedUserData($conn, $data);  
       $selectNewUser = $skinned->selectNewSkinnedUser($conn, $data); 
      // print_r($selectNewUser);
       foreach($selectNewUser as $row ){
           $id = $row['skinnedUserID'];
           $email = $row['skinnedUserEmail']; 
       }
       $dataUser = array(
            'id' => $id,  
            'skinEmail' => $email, 
       );  
       //Auto generate a password link reset
       $skinned->updateResetPw($conn, $dataUser);
       //Get the new generated Reset link
       $getNewResetPWCode = $skinned->getResetPW($conn, $dataUser);
       
       foreach($getNewResetPWCode as $rowx){ 
            if($rowx['Domain'] == null){
                  $domain =  $rootUrl.$rpUrl.'/ID'.$rowx['CustomerNumber'].''.$rowx['themeID'].'/'; 
                  $comp = "www.trendscollection.co.nz";
            }else{
                 $domain = $rowx['Domain'].$rpUrl.'/';
                 $comp = $rowx['Domain'];
            }
            $urlLink = $rowx['skinnedPwReset'];
            $finResetPw = $domain.''.$urlLink;
            $CompanyTag = $rowx['CompanyTag'];
            $AdminEmail = $rowx['customsiteAdminEmail'];
            if($AdminEmail != null){
                  $AdminEmail = $rowx['customsiteAdminEmail'];      
            }else{
                  $AdminEmail = "webmaster@trendscollection.co.nz";
            }
       }

       //echo "Admin email: " .$AdminEmail." / comp: ".$comp."   / company: ".$CompanyTag." / url: ".$finResetPw." -- ";

       $transport = Swift_MailTransport::newInstance();
       // Create the message
       $message = Swift_Message::newInstance();
       //print_r($message);
       $message->setTo(array(
            $data['skinnedUserEmail'] => $data['skinnedUserName'] 
       ));

      $body = "You have been invited to create a login to the ".$CompanyTag." website.<br />
      Once logged in you will be able to access pricing.<br />
      We recommend you keep your login information secure.<br />
      Your login name for the site is your email address (".$data['skinnedUserEmail'].").
      <br /><br />";  
      $body .= "<a href='" .$finResetPw."'>Click here to set up your login</a>"; 
       
      $message->setSubject($CompanyTag. " Login Setup");
      $message->setBody($body, 'text/html');
      $message->setFrom($AdminEmail, $comp);

      // Send the email
      $mailer = Swift_Mailer::newInstance($transport);
      $mailer->send($message); 
      if($mailer->send($message)){
            echo "..Email sent..";
      }else{
            echo "..Email not sent..";
      }
      echo $resultSkinned; 
 }
 
 if($_POST['option']==1){
      $data = array(
            'customsiteID' => $_POST['siteid'], 
            'skinnedCustomerNumber' => $_POST['cn'], 
       ); 
       $outTableUser = $skinned->listSkinnedUser($conn, $data); 
       
       if($outTableUser){ 
            echo '<div class="card-body skinned-container">';  
            echo '<table class="table table-striped pdf-wires-table display" >';
            echo '<thead>
                  <tr>
                  <th>PW</th>
                  <th>Name</th>
                  <th>Company</th>
                  <th>Email</th> 
                  <th>Options</th> 
                  </tr>
            </thead>';
            
            foreach ($outTableUser as $user){ 
                  if($user['skinnedUserPassword'] != ""){
                        $yesPW = '<i class="fa fa-check" aria-hidden="true"></i>';
                  }else{
                        $yesPW = '';
                  } 
                  echo '<tr id="tableRow'.$user['skinnedUserID'].'">
                  <td>'.$yesPW.'</td>
                  <td>'.$user['skinnedUserName'].'</td>
                  <td>'.$user['skinnedUserCompany'].'</td>
                  <td>'.$user['skinnedUserEmail'].'</td> 
                  <td class="text-center"><span class="options-btn editskin editskin'.$user['skinnedUserID'].'" data-toggle="modal" data-target="#skinnedModal" data-id="'.$user['skinnedUserID'].'">Edit</span> 
                  <span class="options-btn resetskin resetskin'.$user['skinnedUserID'].'" data-id="'.$user['skinnedUserID'].'" data-email="'.$user['skinnedUserEmail'].'" data-toggle="modal" data-target="#skinnedModal" >Reset Password</span> 
                  <span class="options-btn deleteskin text-red deleteskin'.$user['skinnedUserID'].'" data-id="'.$user['skinnedUserID'].'" ><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                  </td>';
                  echo '</tr>';  
            } 
            echo '</div>';
      }else{
            echo '<div class="card-body skinned-container text-center"><b>0</b> User</div>';  
      }
 }


 if($_POST['option']==2){ 
      $id = $_POST['id'];
      $selectUser = $skinned->selectSkinnedUser($conn, $id); 
      //print_r($selectUser);
      echo '<form class="form-inline" role="form" id="skinned_edituser" method="post" action=""> ';
      foreach ($selectUser as $user){ 
            echo '<input type="hidden" name="option" id="option"  class="form-control" value="4">';
            echo '<input type="hidden" name="skinid" id="skinid"  class="form-control" value="'.$user['skinnedUserID'].'">';
            echo '<label>Full Name</label>';
            echo '<input type="text" name="skinnedUserNameEdit" id="skinnedUserNameEdit"  class="form-control" value="'.$user['skinnedUserName'].'">';
            echo '<label>Company</label>';
            echo '<input type="text" name="skinnedUserCompanyEdit" id="skinnedUserCompanyEdit"  class="form-control" value="'.$user['skinnedUserCompany'].'">';
            echo '<label>Email Address</label>';
            echo '<input type="text" name="skinnedUserEmailEdit" id="skinnedUserEmailEdit"  class="form-control" value="'.$user['skinnedUserEmail'].'" disabled>';
            echo '<input type="submit" class="btn btn-default editskinneduser-btn  btn-trends margin-top" value="Update User" />';
      }
      echo '</form>';
       
 }
 if($_POST['option']==3){ 
      $id = $_POST['id'];
      $deleteUser = $skinned->deleteSkinnedUser($conn, $id);
      if($deleteUser) {
            echo $deleteUser;
      }  
 }
 
 if($_POST['option']==4){ 

      $data = array(
            'skinID' => $_POST['skinid'], 
            'skinnedUserName' => $_POST['skinnedUserNameEdit'], 
            'skinnedUserCompany' => $_POST['skinnedUserCompanyEdit'],
       );  
       $updateUser = $skinned->skinnedUserUpdate($conn, $data);
       echo $updateUser;
         
       
 }

 //Reset password option
 if($_POST['option']==5){  
            $data = array(
                  'id' => $_POST['id'],  
                  'skinEmail' => $_POST['email'], 
             );  
            
             $reset = $skinned->resetView($conn, $data);

             if($reset == 1){
                   
                  viewResetPWFunction($skinned, $conn, $data, $rootUrl, $rpUrl);
             }
             if($reset == 0){
                  //echo "Walang laman <br />"; 
                 // print_r($data);
                 updateResetPWFunction($skinned, $conn, $data, $rootUrl, $rpUrl);
            }
             
 }

 
 //Generate New Reset password option
 if($_POST['option']==6){  
      $data = array(
            'id' => $_POST['id'],  
            'skinEmail' => $_POST['email'], 
       );   
       updateResetPWFunction($skinned, $conn, $data, $rootUrl, $rpUrl);
}

 
 //Remove or clear Reset password option
 if($_POST['option']==7){  
      $data = array(
            'id' => $_POST['id'],  
            'skinEmail' => null, 
       );   
       removeResetPWFunction($skinned, $conn, $data);
}

 // Send and Reset password option
 if($_POST['option']==8){  
      $data = array(
            'id' => $_POST['id'],  
            'pw' => $_POST['pw'], 
       );   
     $successpw = $skinned->updatePassword($conn, $data);
     echo $successpw;
}


 // Login option
 if($_POST['option']==9){  
      
      $data = array(
            'emailad' => $_POST['emailad'],  
            'pw' => $_POST['pw'], 
       );
       //print_r($data);   
     $loginstatus = $skinned->loginSkinUser($conn, $data);
     if($loginstatus == '1'){
          /*$data = array(
            $_SESSION["userskin_log"] => 1,
            $_SESSION["userskin_email"] => $data['emailad']   
          ); */
           $_SESSION["userskin_log"] = 1;
           $_SESSION["userskin_email"] = $data['emailad'];  
          //$_SESSION["userskin_id"] =  $data['emailad'];
          echo "1";
     }else{
          echo "0";
     }
}

//Logout skin users
if($_POST['option']==10){  
     
            unset($_COOKIE['userskinlog']);
            unset($_COOKIE['userskinemail']);
            unset($_COOKIE['userskintheme']);
            unset($_COOKIE['userskinid']);
            unset($_COOKIE['userskincodehash']);
            /*setcookie("userskinlog",  null, -1, '/'); //eat the cookie
            setcookie("userskinemail", null, -1, '/'); //eat the cookie
            setcookie("userskintheme", null, -1, '/'); //eat the cookie
            setcookie("userskinid", null, -1, '/'); //eat the cookie
            setcookie("userskincodehash", null, -1, '/'); //eat the cookie */
            
 
            setcookie("userskinlog", "", time()-3600); //eat the cookie
            setcookie("userskinlog", "", time()-3600, '/'); //eat the cookie
            
            setcookie("userskinemail", "", time()-3600); //eat the cookie
            setcookie("userskinemail", "", time()-3600, '/'); //eat the cookie

            setcookie("userskintheme", "", time()-3600); //eat the cookie
            setcookie("userskintheme", "", time()-3600, '/'); //eat the cookie

            setcookie("userskinid", "", time()-3600); //eat the cookie
            setcookie("userskinid", "", time()-3600, '/'); //eat the cookie

            setcookie("userskincodehash", "", time()-3600); //eat the cookie
            setcookie("userskincodehash", "", time()-3600, '/'); //eat the cookie

            return true;
     
}

// Validate email option
if($_POST['option']== 11){   
      $data = array(
            'email' => $_POST['email'],  
            'themeID' => $_POST['themeID'], 
            'customerNumber' => $_POST['customerNumber'], 
       );
       //print_r($data);
       $verify = $skinned->verifyEmailforget($conn, $data);
       if($verify == 1){
             echo "1";
       }else{
             echo "0";
       }
}       

      function updateResetPWFunction($skinned, $conn, $data, $rootUrl, $rpUrl){

           /* print_r($conn);
            print_r($data);
            echo $rootUrl;
            echo $rpUrl; */
 
            $resetDone = $skinned->updateResetPw($conn, $data);
            if($resetDone == 1){
                 $getResetPWCode = $skinned->getResetPW($conn, $data);
                  //print_r($getResetPWCode);
                  echo "<p>Copy the newly generated URL below</p>";
                  echo '<form class="form-inline" role="form" id="skinned_reset" method="post" action=""> ';
                  echo '<input type="hidden" name="skinid" id="skinid"  class="form-control" value="'.$data['id'].'">';
                  foreach($getResetPWCode as $row){ 
                       if($row['Domain'] == null){
                             $domain =  $rootUrl.$rpUrl.'/ID'.$row['CustomerNumber'].''.$row['themeID'].'/'; 
                       }else{
                            $domain = $row['Domain'].$rpUrl.'/';
                       }
                       $urlLink = $row['skinnedPwReset'];
                       $finResetPw = $domain.''.$urlLink;
                       echo '<input type="text" name="resetpw_value" id="resetpw_value"  class="form-control" style="max-width:95%" value="'.$finResetPw.'">'; 
                       echo '<span class="btn btn-trends" id="copyLink">Copy Link</span>';
                  }
                  echo '</form>';   
                  
            }else{
                  echo "Problem occured in updating";
            } 

       }


       function viewResetPWFunction($skinned, $conn, $data, $rootUrl, $rpUrl){
             
            $getResetPWCode = $skinned->getResetPW($conn, $data);
            foreach($getResetPWCode as $row){
                 
                 if($row['Domain'] == null){
                       $domain =  $rootUrl.$rpUrl.'/ID'.$row['CustomerNumber'].''.$row['themeID'].'/'; 
                 }else{
                      $domain = $row['Domain'].$rpUrl.'/';
                 }
                 $urlLink = $row['skinnedPwReset'];
                 $finResetPw = $domain.''.$urlLink;
                 echo "<p>Copy the URL below</p>";
                 echo '<input type="text" name="resetpw_value" id="resetpw_value"  class="form-control" style="max-width:95%" value="'.$finResetPw.'">'; 
                 echo '<span class="btn btn-trends" id="copyLink">Copy Link</span> <span class="btn btn-trends" id="generateNewPW"  data-email="'.$data['skinEmail'].'" data-id="'.$data['id'].'">Generate New</span> <span class="btn btn-trends" data-id="'.$data['id'].'"  data-email="'.$data['skinEmail'].'"  id="clearResetPW">Clear</span>';
            } 
            
       }


       //clear reset
       function removeResetPWFunction($skinned, $conn, $data){
             
                        $clearDone = $skinned->removeResetPw($conn, $data);
                        echo $clearDone;
                         
       }

       function url(){
            if(isset($_SERVER['HTTPS'])){
                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            }
            else{
                $protocol = 'http';
            }
            return $protocol . "://" . $_SERVER['HTTP_HOST'];
        }
?>

 


