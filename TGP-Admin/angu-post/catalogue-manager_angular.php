<?php

    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 

  
                //Required for authorization
                include('../config.php');
                include('../settings.php');  
                include('../authenticate.php');   
                 
                
                $headerCookies = explode('; ', getallheaders()['Cookie']); 
                
                $cookiesID = getHeaders($headerCookies); 
                $cookiesID =  rawurldecode($cookiesID); 
                $finalResult = Authenticate($cookiesID);
               
                if(!$finalResult['userID'] || $finalResult['urlAllow']  == 0):
                   return http_response_code(401); 
                   exit;
                endif;
                //Required for authorization

    
    //Mysql table settings
    if($devStuff == 1) {
        $pc = 'productsCurrent';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChangesDEV';
        $pageTrackerTable = 'CMSeditPageTracker';
        $productsStock = 'productsStock';
        $segmentStockCode = 'segmentStockCode';
        $complianceFramework = 'complianceFramework';
        $pdfWires = 'pdfWires';
        $dhl_status_table = 'dhl_status_table';
        $banner_table = 'bannersDEV';
        $catalogue_table = 'catalogueData';
    }else{
        $pc = 'productsCurrent';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChanges';
        $pageTrackerTable = 'CMSeditPageTracker';
        $productsStock = 'productsStock';
        $segmentStockCode = 'segmentStockCode';
        $complianceFramework = 'complianceFramework';
        $pdfWires = 'pdfWires';
        $dhl_status_table = 'dhl_status_table';
        $banner_table = 'bannersTrendsnz';
        $catalogue_table = 'catalogueData';
    } 

     

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

 
   
    $conn = Db::getInstance();  

    include_once("../SimpleImage.php");

    $serverPath = $_SERVER['DOCUMENT_ROOT']; 
     

    if($request->option == 1){
       

    }

    function checkValueYesNo($val){
        if($val == 'Yes'){
            $result = 1;
        }else{
            $result = 0;
        }
        return $result;
    }

    function getLocation($location){
        $locationPublic = 'Banners_loggedout';
        $locationNZ = 'Banners_nz';
        $locationAU = 'Banners_au';
        $locationSG = 'Banners_sg';
        $locationMY = 'Banners_my';

        if($location == 'public'){
            $locationNew = $locationPublic;
        }
        if($location == 'nz'){
            $locationNew = $locationNZ;
        }
        if($location == 'au'){
            $locationNew =  $locationAU;
        } 
        if($location == 'sg'){
            $locationNew =  $locationSG;
        } 
        if($location == 'my'){
            $locationNew =  $locationMY;
        } 
        return $locationNew;
    }

 
?>