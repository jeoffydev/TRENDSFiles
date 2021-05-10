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
    } 

     

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

 
     
    $conn = Db::getInstance();  

    include_once("../SimpleImage.php");

    $serverPath = $_SERVER['DOCUMENT_ROOT']; 
    $pathUrl = $serverPath.'/Images/Banners/';

    if($request->option == 1){
        $updateData = $request->updateData;
        $location = $request->location; 
        
        $locationNew = getLocation($location);

        $valsCount = count($updateData);    
        array_unshift($updateData,"");
        unset($updateData[0]); 

       if($valsCount > 0){

            for ($x = 1; $x <= $valsCount; $x++){  
                 
                $updateDataEach = (array) $updateData[$x];   
                $id = $updateDataEach['id'];
                $url = $updateDataEach['url']; 
                $active = $updateDataEach['active'];
                $main = $updateDataEach['main'];
                $openWindow = $updateDataEach['openWindow'];
                $popup = $updateDataEach['popup'];

                $sqlB = "UPDATE ".$banner_table." SET  orderNum ='" .$x. "', url ='" .$url. "', active ='" .$active. "', main ='" .$main. "', openWindow ='" .$openWindow. "',
                    popup ='" .$popup. "'     WHERE id ='".$id."' AND location  ='".$locationNew."' ";
                $updateB = $conn->query($sqlB);   
                $success = 1; 
            }
        }else{
            $success = 0;
        }
        $data["success"] = $success;
        echo json_encode($data);  

    }
 
    if($request->option == 2){
        $location = $request->location; 
        $locationNew = getLocation($location);
        
        $req = $conn->prepare("SELECT * FROM  ".$banner_table." WHERE location = '".$locationNew."' ORDER BY orderNum  "); 
        $req->execute();
        $results = $req->fetchAll(); 
        
        $someJSON = json_encode($results);
        echo $someJSON;  
    }

    if($request->option == 3){
       $id = $request->id; 
       $filename = $request->filename; 
       $location = $request->location;
     
       $imageFile = $location."/".$filename;
       $command = " DELETE FROM ".$banner_table." WHERE  id= '".$id."'   ";
       $stmt = $conn ->prepare($command); 
       $done = $stmt->execute(); 

       if($done){
            unlink($pathUrl.$imageFile);
       }  
       echo "success";

    }

    if($_POST['options'] == 4){ 

        $bannerData = $_POST['bannerData']; 
        $uid = uniqid();
        $filenameFull = $uid.".jpg";
        $image0 = new \claviska\SimpleImage();
        

        if(!empty($_FILES))  
        {  
             
           // print_r($bannerData);

           // print_r($_FILES);

            $arrLocs = array();
            foreach($bannerData['location'] as $value => $key){
                if($key == 'true'){ 
                    $arrLocs[] = $value;
                }
            }  

            if(count($arrLocs) > 0){
               // print_r($arrLocs);

                if($arrLocs[0] != null || $arrLocs[0] != ""){ 
                    if($arrLocs[0] == 'public'){
                        $bannerLocation = 'Banners_loggedout';
                    }
                    if($arrLocs[0] == 'nz'){
                        $bannerLocation = 'Banners_nz';
                    }
                    if($arrLocs[0] == 'au'){
                        $bannerLocation = 'Banners_au';
                    }
                    if($arrLocs[0] == 'sg'){
                        $bannerLocation = 'Banners_sg';
                    }
                    if($arrLocs[0] == 'my'){
                        $bannerLocation = 'Banners_my';
                    }

                    $main = checkValueYesNo($bannerData['main']);
                    $uploaddir1 = $pathUrl.''.$bannerLocation.'/';
                    $uploaddir2 = $pathUrl.''.$bannerLocation.'/';
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir1."!".$filenameFull); 
                    $image0->fromFile($uploaddir1."!".$filenameFull);

                    if($main == 1){
                        $image0->resize(1920,450);
                    }

                    if($main == 0){
                        $image0->resize(470,200);
                    } 
                    $image0->toFile($uploaddir1.$filenameFull);
                    unlink($uploaddir2."!".$filenameFull);

                    $defaultLocs = $arrLocs[0];
                    $finalFile =   $pathUrl.''.$bannerLocation.'/'.$filenameFull;

                    $url = $bannerData['url'];
                    $active = checkValueYesNo($bannerData['active']);
                    
                    $popup = checkValueYesNo($bannerData['popup']);
                    $open= checkValueYesNo($bannerData['open']);
                    
                    $sql = $conn->prepare("INSERT INTO ".$banner_table." (filename, url, location, orderNum, active, main, popup, openWindow) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); 
                    $insertFirstImage = $sql->execute(array($filenameFull, $url, $bannerLocation, 0, $active, $main, $popup, $open));  
 
                }

                
                foreach($arrLocs as $val){
                    if($defaultLocs != $val){ 

                        if($val == 'public'){
                            $bannerLocation = 'Banners_loggedout';
                        }
                        if($val == 'nz'){
                            $bannerLocation = 'Banners_nz';
                        }
                        if($val == 'au'){
                            $bannerLocation = 'Banners_au';
                        } 
                        if($val == 'sg'){
                            $bannerLocation = 'Banners_sg';
                        } 
                        if($val == 'my'){
                            $bannerLocation = 'Banners_my';
                        } 
                        $newpath = $pathUrl.''.$bannerLocation.'/'.$filenameFull;
                        //echo $newpath. " ===== ";

                        //echo "<br /> FinalFile " .$finalFile;
                          copy($finalFile, $newpath); 

                          $sql = $conn->prepare("INSERT INTO ".$banner_table." (filename, url, location, orderNum, active, main, popup, openWindow) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); 
                          $insertFirstImage = $sql->execute(array($filenameFull, $url, $bannerLocation, 0, $active, $main, $popup, $open));  
                        
                    }
                    
                    
                }
            }


            //print_r($_FILES);
            $results['success'] = 1;
            $results['defeaultOn'] = $arrLocs[0];
             
            $someJSON = json_encode($results);
            echo $someJSON; 
        }

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