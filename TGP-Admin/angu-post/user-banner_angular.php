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
        $pc = 'productsCurrentDEV';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChangesDEV';
        $pageTrackerTable = 'CMSeditPageTracker';
        $customerData = 'customerData';
        $userData = 'userData';
        $cmsAccessTable = 'cmsAccess';
        $banner_table = 'bannersDEV';
    }else{
        $pc = 'productsCurrent';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChanges';
        $pageTrackerTable = 'CMSeditPageTracker';
        $customerData = 'customerData';
        $userData = 'userData';
        $cmsAccessTable = 'cmsAccess';
        $banner_table = 'banners';
    } 

     
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

     

 
    $conn = Db::getInstance();  
    
    include_once("../SimpleImage.php");

    if($request->option == 1){ 
        $customerNumber = $request->customerNumber;
        
        
           
        
            $location = 'Users/'.$customerNumber;
            $req = $conn->prepare("SELECT  * FROM ".$banner_table." WHERE location = '".$location."' ORDER BY id ");  
            $req->execute();
            $results  = $req->fetchAll();

            if(count($results) > 0){
                $results= $results;
            }else{
                $results= 0;
            }
        

        $someJSON = json_encode($results);
        echo $someJSON;  
    } 

    if($request->option == 2){ 
        $userID = $request->userID;
        $req = $conn->prepare("SELECT  userBanner FROM ".$userData." WHERE userID=".$userID." ");  
        $req->execute();
        $resultsID = $req->fetch();

        //IN ('1,3,6,4,7,9')
        if($resultsID['userBanner']){
            $req = $conn->prepare("SELECT  * FROM ".$banner_table." WHERE location = 'Users' AND id IN (".$resultsID['userBanner'].") ORDER BY id ");  
            $req->execute();
            $resultsTemp  = $req->fetchAll();
        }else{
            $resultsTemp = 0;
        }

        $results['bannerIDs'] = $resultsID;
        $results['bannerResults'] = $resultsTemp;
        
        $someJSON = json_encode($results);
        echo $someJSON;  
    }
 
    if($_POST['option'] == 3){ 
        $bannerData = $_POST['bannerData']; 
        $customerNumber = $_POST['customerNumber'];
        $uid = uniqid();
        $filenameFull = $uid.".jpg";
        $image0 = new \claviska\SimpleImage();
        
       // print_r( $bannerData);
       // echo $bannerData['bannerIDs']. " Eto yung bannerID";

        if(!empty($_FILES))  
        {  
            $serverPath = $_SERVER['DOCUMENT_ROOT']; 
            $pathVisualUrl = $serverPath.'/Images/Banners/Users/'; 

             
                
                $filenameTemp = $_FILES['tmp_name'];
                $filename = $_FILES['name'];
     
                if (!file_exists($pathVisualUrl.$customerNumber)) {
                    mkdir($pathVisualUrl.$customerNumber, 0777, true);
                } 
                $uploaddir1 = $pathVisualUrl.$customerNumber.'/';
                $uploaddir2 = $pathVisualUrl.$customerNumber.'/';
                move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir1."!".$filenameFull); 
                $image0->fromFile($uploaddir1."!".$filenameFull);
                $image0->resize(1920,450);
                $image0->toFile($uploaddir1.$filenameFull);
                unlink($uploaddir2."!".$filenameFull);


                $url = $bannerData['url'];
                $active = checkValueYesNo($bannerData['active']);
                $main = checkValueYesNo($bannerData['main']);
                $popup = checkValuePopup($bannerData['popup']); 

                $location = 'Users/'.$customerNumber;
                
                $sql = $conn->prepare("INSERT INTO ".$banner_table." (filename, url, location, orderNum, active, main, popup ) VALUES (?, ?, ?, ?, ?, ?, ?)"); 
                $insertFirstImage = $sql->execute(array($filenameFull, $url, $location, 0, $active, $main, $popup ));  

                $results = 1; 
                 
                $someJSON = json_encode($results);
                echo $someJSON; 
         


        }
         
        
       
        
    }  

     
    if($request->option == 4){
            $updateData = $request->updateData;
            $customerNumbered = $request->customerNumbered; 
    
            

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

                    $location  ='Users/'.$customerNumbered;

                    $sqlB = "UPDATE ".$banner_table." SET  orderNum ='" .$x. "', url ='" .$url. "', active ='" .$active. "', main ='" .$main. "',  
                        popup ='" .$popup. "'     WHERE id ='".$id."' AND location  ='".$location."' ";
                    $updateB = $conn->query($sqlB);   
                    $success = 1; 
                }
            }else{
                $success = 0;
            }
            $data["success"] = $success;
            echo json_encode($data);   

    }

    if($request->option == 5){
            $id = $request->id; 
            $customerNumber = $request->customerNumber;  
            $filename = $request->filename;

            $serverPath = $_SERVER['DOCUMENT_ROOT']; 
            $pathVisualUrl = $serverPath.'/Images/Banners/Users/'.$customerNumber."/"; 
 
        
            $imageFile =   $filename;
            $command = " DELETE FROM ".$banner_table." WHERE  id= '".$id."'   ";
            $stmt = $conn ->prepare($command); 
            $done = $stmt->execute(); 
    
            if($done){
                unlink($pathVisualUrl.$imageFile);
            }  
            echo "success";  
 
     }


    function grind_salt() {
        mt_srand(microtime(true)*100000 + memory_get_usage(true));
        return md5(uniqid(mt_rand(), true));
    }


    function checkValuePopup($val){
         
        if($val == 'Open in Pop Up'){
            $result = 1;
        }
        if($val == 'Open in New Window'){
            $result = 2;
        } 
        if($val == 'Current Window'){
            $result = 0;
        }
        return $result;
    }

    function checkValueYesNo($val){

        
        if($val == 'Yes'){
            $result = 1;
        }else{
            $result = 0;
        }
        return $result;
    }
     
?>
