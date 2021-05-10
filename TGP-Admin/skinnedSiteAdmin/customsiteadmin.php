 
<?php 
   
  $showPricing = $themeResults["showPricing"];
  $customsiteAdminEmail = $themeResults["customsiteAdminEmail"];
  
  /*
  echo '<pre>';
  var_dump($_SESSION);
  echo '</pre>';  

  echo $idSafe. "<br />";

  echo "<pre>";
  print_r($_COOKIE); 
 echo "</pre>";   */
 
  //Settings for Login Menu
  if($showPricing == 2){
        $borderRight = '';  
        $queryThemer = "SELECT * FROM skinnedUserData WHERE skinnedUserID= '".$_COOKIE['userskinid']."' AND  skinnedUserSalt = '".$_COOKIE['userskincodehash']."';";
        $userOutput = dbPuller($queryThemer,0,0); 
        if ($result = mysqli_fetch_array($userOutput)) {
              
                  if($idSafe == $_COOKIE['userskintheme']){
                        $loginSkinnedSite =  2; 
                        //echo "<br />". $custShowPricing;
                  }else{
                        $loginSkinnedSite =  1; 
                  }      
        }else{
            $loginSkinnedSite =  1;
        }

       /* if(isset($_COOKIE['userskinlog'])){ 
            if($idSafe == $_COOKIE['userskintheme']){
                  $loginSkinnedSite =  2; 
            }else{
                  $loginSkinnedSite =  1; 
            }            
        }else{ 
            $loginSkinnedSite =  1;
        } */
        $navClassTop = ' navclasstop';
  }else{
        $loginSkinnedSite = null;  
        $borderRight = ' border-right: none !important ';
        $navClassTop = '';
 
  }
 
 
  $skinDataArray =array(
      'loginSkinnedSite'=>$loginSkinnedSite,
      'showPricing' => $showPricing,
      'custMarkups' => $custMarkups,
      'custMarkupSetup' => $custMarkupSetup,
      'custMarkupBranding'=> $custMarkupBranding,
      'markups' => $markups, 
      'markupSetup' => $markupSetup, 
      'splitDevCharge' => $splitDevCharge, 
      'MOQCharge' => $MOQCharge, 
      'quoteStyle' => $quoteStyle, 
      'custMOQ' => $custMOQ, 
      'custMOQSurcharge' => $custMOQSurcharge, 
      'custAdditText' => $custAdditText 

  );
  
  //echo  $showPricing;
    
?>

 


