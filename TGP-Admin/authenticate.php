<?php
 
    require __DIR__."/Encrypt.php";
    $key = 'wallawallabingbangadingdong'; 


   function Authenticate($cookie){  
            
        $Encrypt = new  Encrypt();
        global $key;
    
        $userID = null;
        if($cookie){  
            
            $encrypted_string = $Encrypt->decode($cookie, $key); 
            $userID = $encrypted_string; 
            
        }else{
            $error = 1;  
            die( http_response_code(401) ); 
            exit;
        }  

        //Check if user is logged in
        $userAuth = 0; 
        $userArray = getUserAdmin($userID);  

        $userAuthID = null;  
        $userAccess = null;
        $allowaccess = 0; 
        $thisPage = 0;

         /*
            Get pages of CMS and compare to the user's access 
            Get the Url and file from angu-post ex. TGP-Admin/angu-post/user-management_angular.php
            Note: we dont have url query strings hee, so parse will give us only 1 array variable which is [path]
            Only the $_SERVER['REQUEST_URI'] so we can direct the URL in TGP-Admin, since we also have pens.nz/trends.com.au/trends.nz
        */
        $get_uri =   parse_url($_SERVER['REQUEST_URI']);
         //filter the url path into ex. user-management Note: this will be standard in all pages of angu-post/
        $request_uri = substr($get_uri['path'], 11); 
        $arrayUri = explode('/', $request_uri); 
        $lessPage = substr($arrayUri[1], 0, -12);
         //get the pageNumber of this file
        $thisPage = getAuthenticatePageNumber($lessPage);
        //get the user's access in comma separated
        $resultPages = explode(',', $userArray['results']['userAccess']); 
        // Get pages of CMS and compare to the user's access 
        
        //Compare this pageNumber to user's access. If found then allow if not then $allowaccess = 0
        if (in_array($thisPage, $resultPages)) { 
            $allowaccess = 1;
        }   
        
        if( $userArray['letmein'] == 1 && $userArray['results']['userType'] == 0 && $userArray['results']['CustomerOnHold'] == "N" ){  
              $userAuth = 1;  
              $userAuthID =  $userArray['results']['userID'];
              $userAccess = $userArray['results']['userAccess']; 
        }    

        return array("userID"=> $userAuthID, "userAuth" => $userAuth, "userDetails" => $userArray, "decryptedAccess"=>$userAccess, 'thisPage'=> $thisPage, 'urlAllow'=> $allowaccess);

   } 
 
   function getHeaders($headerCookies){ 
       //$headerCookies will return this in time for the other cookies
        return $_COOKIE['user_cookies'];
   }

   function getAuthenticatePageNumber($page) {  
        $conn = Db::getInstance();
        $req = $conn->query("SELECT * FROM cmsAccess WHERE accessPage = '".$page."' AND mainPage = '0' "); 
        $req->execute();
        $results = $req->fetch(); 
        return $results['pageNumber'];
    }
 
   
    
     
?>