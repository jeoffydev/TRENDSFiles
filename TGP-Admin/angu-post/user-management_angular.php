<?php
      

    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )   ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
 
                
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
                    $secondaryUserAccount = 'secondaryUserAccount';
                }else{
                    $pc = 'productsCurrent';
                    $colourSearchTable = 'colourSearch';
                    $changeTypeTable = 'productChangeTypes';
                    $productsChangesTable = 'productsChanges';
                    $pageTrackerTable = 'CMSeditPageTracker';
                    $customerData = 'customerData';
                    $userData = 'userData';
                    $cmsAccessTable = 'cmsAccess';
                    $secondaryUserAccount = 'secondaryUserAccount';
                } 
            
                
                

                include_once('../skinnedSiteAdmin/lib/swift_required.php'); 
                include_once('../../application/libraries/PHPMailer/PHPMailerAutoload.php'); 
            
                
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
 
                

                $conn = Db::getInstance();  
                
                if($request->option == 1){  
                

                    $customerNumber = $request->customerNumber;
                    $req = $conn->prepare("SELECT * FROM ".$userData." WHERE userAcct=".$customerNumber." ORDER BY userEmail");  
                    $req->execute();
                    $results['usersList'] = $req->fetchAll();
                    
                    //Get the Visual Access of this Distributor
                    $req = $conn->prepare('SELECT visualAccess, Currency, CustomerOnHold, CSR FROM  '.$customerData.'  WHERE CustomerNumber = "'.$customerNumber.'" '); 
                    $req->execute();
                    $resultExist = $req->fetch();
                    $results['customerAccess'] = $resultExist;
                    

                    $someJSON = json_encode($results);
                    echo $someJSON;  
                } 

                
            
                if($_POST['option'] == 2){ 
                    
                    $newSalt = grind_Salt();
                    $adminEmail =  $_POST['userAdminEmail'];
                    $newUserEmail = $_POST['userEmail'];
                    /* echo $newSalt;
                    echo $_POST['userAdminEmail'];
                    echo $_POST['userEmail'];
                    echo $_POST['customerNumber']; */

                    $req = $conn->prepare("SELECT * FROM ".$userData." WHERE  userEmail = '".$_POST['userEmail']."'  "); 
                    $req->execute();
                    $results = $req->fetch(PDO::FETCH_ASSOC);
                    if($results > 0){ 

                        $req = $conn->prepare('SELECT CustomerName FROM  '.$customerData.'  WHERE CustomerNumber = "'.$results['userAcct'].'" '); 
                        $req->execute();
                        $resultExist = $req->fetch();
                        //print_r($resultExist);
                        $resultExist['companyName'] = $resultExist['CustomerName'];
                        $resultExist['found'] = 1;
                        $someJSON = json_encode($resultExist);
                        echo $someJSON;  

                    }else{
                        //userAcct, userEmail, userSalt
                        $sql = $conn->prepare("INSERT INTO ".$userData." (userAcct, userEmail, userSalt) VALUES(?, ?, ?)"); 
                        $insertGetID = $sql->execute(array($_POST['customerNumber'], $_POST['userEmail'], $newSalt));  
                        $lastIDinserted =  $conn->lastInsertId(); 
                        $resetEmailLink = $newSalt.".".$lastIDinserted; 
                        $getCustomerData= $conn->prepare("SELECT * FROM ".$customerData." WHERE customerNumber='".$_POST['customerNumber']."' ");  
                        $getCustomerData->execute();
                        $getCustomerDataResults = $getCustomerData->fetch(PDO::FETCH_ASSOC);
                        
                        
                        if($getCustomerDataResults['Currency'] == "NZD") {
                            $whichDomain = "www.trends.nz";
                        } else {
                            $whichDomain = "www.trends.nz";
                        }  
                    

                        $mail = new PHPMailer; 
                        
                    
                        $mail->isSMTP();
                        $mail->Host = 'smtp.sitehost.co.nz';
                        //$mail->Host = 'tuapeka-co-nz.mail.protection.outlook.com';
                    // $mail->SMTPAutoTLS = false;
                        $mail->SMTPAuth = false; 
                        $mail->Port = 25;

                        $mail->setFrom($adminEmail, $whichDomain); 
                        $mail->addAddress($newUserEmail);
                        $mail->addAddress($adminEmail);
                        
                        $mail->isHTML(true);
                        $mail->Subject = "TRENDS Website Login"; 
                        
                        $body = "You have been invited to create a login to the TRENDS website.<br />";
                        $body .= "Once logged in you will be able to access stock and pricing information on the fly when viewing items.<br />";
                        $body .= "Planned future updates will include access to order status, order history and account information.<br />";
                        $body .= "We recommended to keep your login information secure.<br />";
                        $body .= "Your login name for the site is your email address (".$newUserEmail.").<br />";
                        $body .= "<br />";
                        $body .= "Click here to set up your login <a href='https://".$whichDomain."/reset-password/".$resetEmailLink."'> https://".$whichDomain."/reset-password/".$resetEmailLink." </a><br /><br />";
            

                        $mail->Body    = $body;

                        if(!$mail->send()) {
                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                            
                        } 
                        echo "0";  
                    }
                // print_r($results);
                    
                }

                if($request->option == 3){ 
                    $userID =  $request->customerID;
                    $command = " DELETE FROM ".$userData." WHERE userID =:userID";
                    $stmt = $conn ->prepare($command);
                    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
                    $done = $stmt->execute(); 
                    echo "1";
                }

                if($request->option == 4){ 
                    $userID= $request->userID;
                    $hash = $request->hash;
                    $userCustNum = $request->userCustNum;
                    
                    $req = $conn->prepare("SELECT * FROM ".$userData." LEFT OUTER JOIN ".$customerData." ON ".$customerData.".CustomerNumber = ".$userData.".userAcct WHERE userID=".$userID."  ");  
                    $req->execute();
                    $results = $req->fetch();
                    
                    if($hash == 1){ 
                        $userPW = $results['userSalt'].".".$results['userID']; 
                        $sql = "UPDATE ".$userData." SET   pwReset= '".$userPW."' WHERE userID='".$userID."'";
                        $userReset = $conn->query($sql);  
                        //Reselect to get the pwReset value
                        $reqUpdate = $conn->prepare("SELECT * FROM ".$userData."   WHERE userID=".$userID."  ");  
                        $reqUpdate->execute();
                        $resultReqUpdate = $reqUpdate->fetch();
                        $resetUrl = $resultReqUpdate['pwReset'];
                    }else{
                        $resetUrl = $results['userSalt'].'.'.$results['userID'];
                    }
                    if($results['Currency'] == 'NZD'){
                        $urlDomain = "www.trends.nz";
                    }else{
                        $urlDomain = "www.trends.nz";
                    } 
                    // http://localhost/?changeid=3312&country=nzd
                    $results['finalResetUrl'] = $urlDomain. "/reset-password/" .$resetUrl; 

                    $someJSON = json_encode($results);
                    echo $someJSON;   
                }

            
                if($_POST['option'] == 5){ 

                    if($_POST['CustomerNumber']){
                        
                        $custNum = $_POST['CustomerNumber'];
                        $userID = $_POST['userID'];
                        $userEmail = $_POST['userEmail'];
                        $str_arr = explode (",", $custNum); 
                        $custNum = $str_arr[0];

                        /* $req = $conn->prepare("SELECT * FROM ".$userData." WHERE userAcct='".$custNum."' AND userEmail = '".$userEmail."'  "); 
                        $req->execute();
                        $results = $req->fetch(PDO::FETCH_ASSOC);
                        if($results > 0){
                            echo "1";
                        }else{ */
                            $sql = "UPDATE ".$userData." SET   userAcct= '".$custNum."' WHERE userID='".$userID."'";
                            $userReset = $conn->query($sql);   

                            if($userReset){
                                $sql2 = "UPDATE ".$secondaryUserAccount." SET   primaryAccountID= '".$custNum."' WHERE userID='".$userID."' AND userEmail='".$userEmail."' ";
                                $userReset2 = $conn->query($sql2);    
                            }
                            echo "0";
                    /*  } */
                    
                    }
                
                }

                if($request->option == 6){ 
                    $userID= $request->userID;
                    $req = $conn->prepare("SELECT * FROM ".$userData."  WHERE userID=".$userID."  ");  
                    $req->execute();
                    $results = $req->fetch();
                    
                    //Get Pages
                    $reqs = $conn->prepare("SELECT * FROM ".$cmsAccessTable." WHERE mainPage = '1' ORDER BY pageNumber ASC "); 
                    $reqs->execute();
                    $resultPages = $reqs->fetchAll();
                    $rsCount =  count($resultPages);

                    //Get the Main company VisualAccess
                    $customerNumbered = $request->customerNumbered;
                    $reqC = $conn->prepare("SELECT visualAccess FROM ".$customerData."  WHERE CustomerNumber=".$customerNumbered."  ");  
                    $reqC->execute();
                    $resultsCompany = $reqC->fetch();
                    $results['visualAccessUser'] = $resultsCompany;


                    $reqSec = $conn->prepare("SELECT * FROM ".$secondaryUserAccount." WHERE userID = '".$userID."'  AND primaryAccountID='".$customerNumbered."'  ORDER BY id "); 
                    $reqSec->execute();
                    $resultSec = $reqSec->fetchAll();
                    $results['secondaryAccount'] = $resultSec;

                    $results['selectAccess'] = $resultPages;

                    $someJSON = json_encode($results);
                    echo $someJSON;   
                }

                if($_POST['option'] == 7){ 

                

                    $data = array();
                    $error = array();

                    $userID= $_POST['userID'];
                    $userType= $_POST['selectYesNoFin'];
                    $multiCurrency= $_POST['selectYesNoCurrency'];
                    $customSiteUser= $_POST['selectYesNoCustom'];
                    $skinnedWebsites= $_POST['selectYesNoSkinned'];
                    $apiAcc= $_POST['selectYesNoApi'];
                    $orderDashboard= $_POST['selectYesNoOrderDashboard'];

                    //Determine BrandStore access and role
					switch ($_POST['brandStoreAccess'])
					{
						case 'admin':
							$brandStoreAccess = 1;
							$brandStoreRole = 'admin';
							break;

						case 'editor':
							$brandStoreAccess = 1;
							$brandStoreRole = 'editor';
							break;

						default:
							$brandStoreAccess = 0;
							$brandStoreRole = 'noAccess';
							break;
					}

                    //VisualAccess
                    $visualAccess= $_POST['selectYesNoVisualAccess'];
                    $customerNumbered= $_POST['customerNumbered'];

                    $pagesAccess = $_POST['pageNumberSelected'];
                    $pagesAccessString = implode(",", $pagesAccess);

                    if(!empty($error)) {
                        $data["error"] = $error;   
                    }else{

                        $datas = [
                            'userType' => $userType,
                            'multiCurrency' => $multiCurrency,
                            'customSiteUser' => $customSiteUser,
                            'skinnedWebsites' => $skinnedWebsites,
                            'apiAcc' => $apiAcc,
                            'userAccess' => $pagesAccessString,
                            'OrderDashboardAccess' => $orderDashboard,
                            'userID'=> $userID,
							'brandStoreAccess' => $brandStoreAccess,
							'brandStoreRole'=> $brandStoreRole
                        ];


                        $sql = "UPDATE ".$userData." SET   userType=:userType, multiCurrency=:multiCurrency, customSiteUser=:customSiteUser, skinnedWebsites=:skinnedWebsites, apiAcc=:apiAcc, userAccess=:userAccess,  OrderDashboardAccess=:OrderDashboardAccess, BrandStoreAccess=:brandStoreAccess, BrandStoreRole=:brandStoreRole WHERE userID=:userID";
                        $userReset = $conn->prepare($sql);
                        $userReset->execute($datas);

  

                        $data["message"] = " User successfully Updated ";   
                    } 

                    echo json_encode($data);  
                
                }

                if($request->option == 8){ 
                    $customerNumber = $request->customerNumber;
                    $newCurrency = $request->newCurrency;
                    $customerNumbered = $request->customerNumbered;
                    $userID = $request->userID;
                    $userEmail = $request->userEmail; 
                    $customerName = $request->customerName;


                    $req = $conn->prepare("SELECT * FROM ".$secondaryUserAccount." WHERE  secondaryAccountID = '".$customerNumber."' AND primaryAccountID = '".$customerNumbered."'  AND secondaryCurrency = '".$newCurrency."' AND userID = '".$userID."'  "); 
                    $req->execute();
                    $results = $req->fetch(PDO::FETCH_ASSOC);
                    if($results > 0){ 
                        echo "1";
                    }else{


                        $reqMark = $conn->prepare("SELECT * FROM ".$userData." WHERE  userID = '".$userID."'  "); 
                        $reqMark->execute();
                        $resultsMark = $reqMark->fetch(PDO::FETCH_ASSOC); 
                        //print_r($resultsMark);
                        $resultMark1 = $resultsMark['markup1'];
                        $resultMark2 = $resultsMark['markup2'];
                        $resultMark3 = $resultsMark['markup3'];
                        $resultMark4 = $resultsMark['markup4'];
                        $resultMark5 = $resultsMark['markup5'];
                        $resultMark6 = $resultsMark['markup6'];
                        $resultSetupMark = $resultsMark['setupMarkup'];

                        $reqCheck = $conn->prepare('SELECT Currency FROM  '.$customerData.'  WHERE  CustomerNumber = "'.$resultsMark['userAcct'].'" AND Currency = "'.$newCurrency.'"  '); 
                        $reqCheck->execute();
                        $resultOverlap = $reqCheck->fetch(PDO::FETCH_ASSOC); 
                        //print_r($resultsMark);
                        //print_r($resultOverlap);
                        //echo $customerNumber. " => " .$resultsMark['userAcct']. " / " .$resultOverlap['Currency']. " => " .$newCurrency;
                        if (($customerNumber == $resultsMark['userAcct']) && ($resultOverlap['Currency'] == $newCurrency) ) {
                            echo "2";
                        }else{
                            $sql = $conn->prepare("INSERT INTO ".$secondaryUserAccount." (secondaryAccountID, secondaryAccountName, secondaryCurrency, primaryAccountID, userID, userEmail, markup1, markup2, markup3, markup4, markup5, markup6, setupMarkup) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); 
                            $insertNewCurrency = $sql->execute(array($customerNumber, $customerName, $newCurrency, $customerNumbered, $userID, $userEmail, $resultMark1, $resultMark2, $resultMark3, $resultMark4, $resultMark5, $resultMark6, $resultSetupMark)); 
                            if( $insertNewCurrency){
                                echo "0";
                            } 
                        }

                        
                        
                    }   

                }

                if($request->option == 9){ 
                
                    $id =  $request->id;
                    $command = " DELETE FROM ".$secondaryUserAccount." WHERE id =:id";
                    $stmt = $conn ->prepare($command);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $done = $stmt->execute(); 
                    echo "1";
                }

                if($request->option == 10){
                    $customerNumber =  $request->customerNumber;
                    $val =  $request->val;
                    $sql = "UPDATE ".$customerData." SET   visualAccess= '".$val."' WHERE CustomerNumber='".$customerNumber."'";
                    $visualResults = $conn->query($sql); 
                    if($visualResults){
                            echo "1";
                    } 
                
                }


                if($request->option == 11){ 
                    $opts = $request->opts;
                    $ch = "";
                    if(!$opts){
                        $ch = "WHERE customerData.CustomerOnHold =  'N' ";
                    } 
                    $req = $conn->prepare('SELECT userID, userAcct, userEmail, userHash, userType, multiCurrency, apiAcc, skinnedWebsites, customSiteUser, CustomerNumber, CustomerName,  Currency, CustomerOnHold, visualAccess, CSR 
                    FROM  userData  JOIN  customerData ON userData.userAcct = customerData.CustomerNumber   '.$ch.' ORDER BY userID DESC '); 
                    $req->execute();
                    $results = $req->fetchAll(); 

                    $someJSON = json_encode($results);
                    echo $someJSON;  
                } 


                function grind_salt() {
                    mt_srand(microtime(true)*100000 + memory_get_usage(true));
                    return md5(uniqid(mt_rand(), true));
                }

        
    
?>
