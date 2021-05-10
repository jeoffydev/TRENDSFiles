<?php
     //session_start();
    $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
 
   


   //Error 
    
   /* ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL); */
  
   

    //Get the TGP setup and logcheck
    
    require_once('config.php');
    include_once("settings.php");  
    include_once("authenticate.php");  
 
    
    if(isset($_COOKIE["user_cookies"])):
        $cookie = $_COOKIE["user_cookies"]; 
    else: 
        $cookie = null;
        die( header( 'location: ../' ) ); 
    endif;
    //Make seesion of cookie
    //$_SESSION["getThisCMSCookie"] = $cookie;
     
    $authArray = Authenticate($cookie); 
    if($authArray['userID'] !== null){
        $userArray = $authArray['userDetails'];
        $userID =  $authArray['userID']; 
    } 
 

    //$userAuth = 1;  
    if($authArray['userAuth'] != 1) {
            $error = 1;  
            die( header( 'location: ../' ) ); 
            exit;  
            
    } else { 
 
        
        include('controllers/Controller.php'); 
        include('models/Model.php');  
        include('angu-post/Angular.php');   
       

        $userEmail = $userArray['results']['userEmail'];
        $userType = $userArray['results']['userType'];
        $companyName = $userArray['results']['CustomerName'];
        $userAccnt = $userArray['results']['userAcct'];
        $randNum = rand(); 

        //Main Model Function
        $model = new  Model();
        $siteModel = $model->getModel();
        if($siteModel != null || $siteModel != ""){
            $model->callModel($siteModel);
        }
        
        //Main Controller Function
        $controller = new  Controller();
        $siteController = $controller->getController();
        if($siteController != null || $siteController != ""){
            $controller->callController($siteController);
        }

        //Main Angular Function
        $angular = new  Angular();
        $siteAngular = $angular->getAngular();
        $angularFooter = "";
        if($siteAngular != null || $siteAngular != ""){
            $angularFooter = $angular->callAngular($siteAngular);
            $angularPost = $angular->callPostAngular($siteAngular);
            $angularControllerFile = $angular->getAngularController($siteAngular);
            $angularModelFile = $angular->getAngularModel($siteAngular);
            $getPostRequestAngular = $angular->getPostRequestAngular($siteAngular);
        }

         
       
        //Get the page access 
        $lessPage = substr($request_uri[0], 11); 
        $thisPage = $controller->getPage($lessPage);
        //Get User Array access
        $userAccess = $controller->getUserPage($userID); 
        $resultPages = explode(',', $userAccess); 
        //Add home default as 1 
        //Get all pages
        $allPages = $controller->getAllPages(); 
        
        array_push($resultPages, "1");
        if (in_array($thisPage, $resultPages)) { 

           $explode = explode("/",  $request_uri[0]);
           $backEndFile = $explode[2]; 
            
            switch ($request_uri[0]) {
                // Home page 
                case $navUrl.'/home':  
                    require 'views/home.php'; 
                    break;  
                case $navUrl.'/user-management': 
                    require 'views/user-management.php';  
                    break; 
                case $navUrl.'/user-banner': 
                    require 'views/user-banner.php';
                    break; 
                case $navUrl.'/add-products':  
                    require 'views/add-products.php';
                    break; 
                case $navUrl.'/edit-products':  
                    require 'views/edit-products.php';
                    break;   
                case $navUrl.'/add-pricing':   
                    require 'views/add-pricing.php';
                    break;   
                case $navUrl.'/edit-pricing':  
                    require 'views/edit-pricing.php';
                    break;
                case $navUrl.'/image-manager':  
                    require 'views/image-manager.php';
                    break;
                case $navUrl.'/featured-items':   
                    require 'views/featured-items.php';
                    break;
                case $navUrl.'/compliance-manager':   
                    require 'views/compliance-manager.php';
                    break;
                case $navUrl.'/branding-manager':   
                    require 'views/branding-manager.php';
                    break;    
                case $navUrl.'/skinned-website':   
                    require 'views/skinned-website.php';
                    break;    
                case $navUrl.'/skinned-site-user':   
                    require 'views/skinned-site-user.php';
                    break;    
                case $navUrl.'/track-trace-manager':   
                    require 'views/track-trace-manager.php';
                    break;  
                case $navUrl.'/banner-manager':   
                    require 'views/banner-manager.php';
                    break;  
                case $navUrl.'/file-uploader':   
                    require 'views/file-uploader.php';
                    break;  
                case $navUrl.'/email-banner-uploader':   
                    require 'views/email-banner-uploader.php';
                    break;    
                case $navUrl.'/additional-cost-configurator':   
                    require 'views/additional-cost-configurator.php';
                    break;    
                case $navUrl.'/on-demand-stock':   
                    require 'views/on-demand-stock.php';
                    break;    
                case $navUrl.'/catalogue-manager':   
                    require 'views/catalogue-manager.php';
                    break;   
                               
                
                // Error
                default:
                    header('HTTP/1.0 404 Not Found');
                    require 'views/404.php';
                    break;
                    
            } 
 
                
           

        }else{
            header('HTTP/1.0 404 Not Found');
            require 'views/404.php';
        } 
        
         

        

    } 
    
    
    
?>