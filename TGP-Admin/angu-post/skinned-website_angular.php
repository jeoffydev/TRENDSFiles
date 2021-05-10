<?php

    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 

   // include_once("../../setup.php");  
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
        $customSite = 'customSite';
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
        $customSite = 'customSite';
        $banner_table = 'bannersTrendsnz';
    } 

 

  
   
    $conn = Db::getInstance();  


        
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

    $serverPath = $_SERVER['DOCUMENT_ROOT']; 
    $pathLogoUrl = $serverPath.'/Images/TopMenu/customerLogos/'; 
    $pathMobileLogoUrl = $serverPath.'/Images/TopMenu/customerLogos/MobileLogos/'; 
    $pathOGUrl = $serverPath.'/OGImages/'; 

    include_once("../SimpleImage.php");
    
    if($request->option == 1){ 
        $customerNumber = $request->customerNumber;
        $req = $conn->prepare("SELECT * FROM ".$customSite." WHERE customerNumber=".$customerNumber." ORDER BY CompanyTag");  
        $req->execute();
        $results = $req->fetchAll();
        
        $reqThemeSiteMax = $conn->prepare("SELECT * FROM ".$customerData." WHERE customerNumber=".$customerNumber." ");  
        $reqThemeSiteMax->execute();
        $resultsThemeSiteMax = $reqThemeSiteMax->fetch();
        
        $results['ThemedSiteMax'] = $resultsThemeSiteMax['ThemedSiteMax']; 
        
        $someJSON = json_encode($results);
        echo $someJSON;  
    } 

    if($request->option == 2){ 
        $selectedThemeID = $request->selectedThemeID;
        $req = $conn->prepare("SELECT * FROM ".$customSite." WHERE themeID=".$selectedThemeID." ");  
        $req->execute();
        $results = $req->fetch(); 
        
         
        //Get Logo
        $Exist = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$selectedThemeID.".jpg";
        $Exist2 = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$selectedThemeID.".png";
        $Exist3 = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$selectedThemeID.".gif";

        $ExistFavicon = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/favicon/".$selectedThemeID.".ico";

        $ExistOGImage = $_SERVER['DOCUMENT_ROOT']."/OGImages/".$selectedThemeID.".jpg";
        $ExistOGImage2 = $_SERVER['DOCUMENT_ROOT']."/OGImages/".$selectedThemeID.".png";
 
        $ExistMobileLogo = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/MobileLogos/".$selectedThemeID.".png";

         
		if(file_exists($Exist)) {
            $results['LogoExist'] = 1;
            $results['LogoUrl'] = "Images/TopMenu/customerLogos/".$selectedThemeID.".jpg";
		}elseif(file_exists($Exist2)) {
            $results['LogoExist'] = 1;
            $results['LogoUrl'] = "Images/TopMenu/customerLogos/".$selectedThemeID.".png";
		}elseif(file_exists($Exist3)) {
            $results['LogoExist'] = 1;
            $results['LogoUrl'] = "Images/TopMenu/customerLogos/".$selectedThemeID.".gif";
		}else{
            $results['LogoExist'] = 0;
            $results['LogoUrl'] = 0;
        }

        if(file_exists($ExistFavicon)) {
            $results['FaviconExist'] = 1;
            $results['FaviconUrl'] = "Images/TopMenu/customerLogos/favicon/".$selectedThemeID.".ico";
		}else{
            $results['FaviconExist'] = 0;
            $results['FaviconUrl'] = 0;
        }

        if(file_exists($ExistOGImage)) {
            $results['OGImageExist'] = 1;
            $results['OGImageUrl'] = "OGImages/".$selectedThemeID.".jpg";
		}elseif(file_exists($ExistOGImage2)) {
            $results['OGImageExist'] = 1;
            $results['OGImageUrl'] = "OGImages/".$selectedThemeID.".png";
		}else{
            $results['OGImageExist'] = 0;
            $results['OGImageUrl'] = 0;
        }


        if(file_exists($ExistMobileLogo)) {
            $results['MobileLogoExist'] = 1; 
            $results['MobileLogoUrl'] = "Images/TopMenu/customerLogos/MobileLogos/".$selectedThemeID.".png";
		}else{
            $results['MobileLogoExist'] = 0;
            $results['MobileLogoUrl'] = 0;
        }



        $results['AboutUsText'] = htmlspecialchars_decode($results['AboutUsText']);
        $results['ContactUsText'] = htmlspecialchars_decode($results['ContactUsText']);
        $results['termsConditionText'] = htmlspecialchars_decode($results['termsConditionText']);

        
        /* Banner */
        $reqBanner = $conn->prepare("SELECT * FROM ".$banner_table." WHERE location=".$selectedThemeID." ORDER BY orderNum ");  
        $reqBanner->execute();
        $results['skinnedBanner'] = $reqBanner->fetchAll(); 


        $someJSON = json_encode($results);
        echo $someJSON;  
    } 
    if($request->option == 3){ 
        $newTheme = $request->newTheme;
        $customerNum = $request->customerNum;
        $sqlChange = $conn->prepare("INSERT INTO ".$customSite." (CompanyTag, CustomerNumber) VALUES(?, ?)"); 
        $insertChange = $sqlChange->execute(array($newTheme, $customerNum));    
      
        echo $conn->lastInsertId(); 

    }

    if($request->option == 4){ 
        $selectedThemeID = $request->selectedThemeID;
        $customerNumber = $request->customerNumber;
        $command = " DELETE FROM ".$customSite." WHERE  CustomerNumber= '".$customerNumber."' AND themeID = '".$selectedThemeID."' ";
        $stmt = $conn ->prepare($command); 
        $done = $stmt->execute();  

        if($done){
            echo "1";
        }
    }
     
    if($_POST['options'] == 5){ 
        $themeID = $_POST['themeID'];    
        $opts = $_POST['opts'];    
         //print_r($_FILES);


        try {

                if($_FILES['file']['error'] === UPLOAD_ERR_OK) {    
                    //print_r($_FILES);
                //echo "Eto na yun";

                $image0 = new \claviska\SimpleImage();
                
                    if($opts == 1){
                        
                            $fname = $_FILES["file"]["name"];
                            $Fextension = strtolower(end((explode(".", $fname))));
                            //$pathLogoUrl
                            $filenameFull = $themeID.".".$Fextension;
                
                            $filenameDel = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$themeID.".jpg";
                            if(file_exists($filenameDel)) {
                                unlink($filenameDel);
                            }
                            
                            $filenameDel = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$themeID.".png";
                            if(file_exists($filenameDel)) {
                                unlink($filenameDel);
                            }
                            
                            $filenameDel = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$themeID.".gif";
                            if(file_exists($filenameDel)) {
                                unlink($filenameDel);
                            }
                            
                            move_uploaded_file($_FILES["file"]["tmp_name"], $pathLogoUrl."!".$filenameFull);
                            
                           
                            $image0->fromFile($pathLogoUrl."!".$filenameFull);
                            $image0->bestFit(700,87);
                            
                            
                            $image0->toFile($pathLogoUrl.$filenameFull);
                            unlink($_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/!".$filenameFull);
                            
                            echo "1";  
                    }
                    if($opts == 2){
            
                        
                            include_once('../class-php-ico.php');
                            $fname2 = $_FILES["file"]["name"];
                            $Fextension2 = end((explode(".", $fname2)));
                        // echo "Favicon"; 
                            $source = $pathLogoUrl.'favicon/!'.$themeID.".".$Fextension2;
                            $destination = $_SERVER['DOCUMENT_ROOT'].'/Images/TopMenu/customerLogos/favicon/'.$themeID.'.ico';
                            
                            if(file_exists($destination)) {
                                unlink($destination);
                            }
                            
                            move_uploaded_file($_FILES["file"]["tmp_name"], $source);
                            $source = $_SERVER['DOCUMENT_ROOT'].'/Images/TopMenu/customerLogos/favicon/!'.$themeID.".".$Fextension2;
                
                            $sizes = array(
                                array( 16, 16 ),
                                array( 24, 24 ),
                                array( 32, 32 ),
                                array( 48, 48 ),
                            );
                            
                            $ico_lib = new PHP_ICO( $source, $sizes );
                            $ico_lib->save_ico( $destination ); 
                            unlink($_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/favicon/!".$themeID.".".$Fextension2);
            
                            echo "1";  
                            
                    } 
            
                    if($opts == 3){
                            
                            $fname = $_FILES["file"]["name"];
                            $Fextension = strtolower(end((explode(".", $fname))));
                            //$pathLogoUrl
                            $filenameFull = $themeID.".".$Fextension;
                
                            $filenameDel = $_SERVER['DOCUMENT_ROOT']."/OGImages/".$themeID.".jpg";
                            if(file_exists($filenameDel)) {
                                unlink($filenameDel);
                            } 

                            $filenameDel = $_SERVER['DOCUMENT_ROOT']."/OGImages/".$themeID.".png";
                            if(file_exists($filenameDel)) {
                                unlink($filenameDel);
                            } 
                            
                            move_uploaded_file($_FILES["file"]["tmp_name"], $pathOGUrl."!".$filenameFull);
                            
                            
                            $image0->fromFile($pathOGUrl."!".$filenameFull);
                            $image0->bestFit(1200,630);
                            
                            
                            $image0->toFile($pathOGUrl.$filenameFull);
                            unlink($_SERVER['DOCUMENT_ROOT']."/OGImages/!".$filenameFull);
                            
                            echo "1";  
                            
            
                    }

                    if($opts == 4){

                        $fname = $_FILES["file"]["name"];
                        $Fextension = strtolower(end((explode(".", $fname))));
                        //$pathMobileLogoUrl
                        $filenameMobileFull = $themeID.".".$Fextension;
                       
                        $filenameDelMobile = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/MobileLogos/".$themeID.".png";
                        if(file_exists($filenameDelMobile)) {
                            unlink($filenameDelMobile);
                        }
                        

                        move_uploaded_file($_FILES["file"]["tmp_name"], $pathMobileLogoUrl."!".$filenameMobileFull);
                        $image0->fromFile($pathMobileLogoUrl."!".$filenameMobileFull);
                        $image0->bestFit(320, 80);
                        
                        
                        $image0->toFile($pathMobileLogoUrl.$filenameMobileFull);
                        unlink($_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/MobileLogos/!".$filenameMobileFull);
                        
                        echo "1";  

                    }
            
                }
       

        } //Try

        //Catch
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }


    }

    if($request->option == 6){ 
        $custName = $request->custName;
        $custNumber = $request->custNumber;
        $themeID   = $request->themeID;

        $command = " INSERT INTO ".$customSite." (CustomerNumber, CompanyTag, Live, BackgroundColour, Phone, Email, Address, Twitter, Facebook, LinkedIn, Skype, GooglePlus, headerBackground, headerTrimColour, headerTextColour, searchBoxColour, searchBoxTextColour, CategoryIconOverlay, categoryTextColour, paragraphTextColour, tabColour, tabTextColour, tabTextColourHover, tabSelectedColour, tabSelectedText, tableBorderColour, tableHeaderColour, tableHeaderTextColour, tableCellColour, tableCellTextColour, menuHighlightColour, textHighlightColour, menuHoverBackground, ContactUsText, AboutUsText, AdditionalInformation, Q1Markup, Q2Markup, Q3Markup, Q4Markup, Q5Markup, SetupMarkup, BrandingPriceMarkup, showPricing, allowMOQ, MOQSurcharge, PricingInformation1, PricingInformation2, PricingInformation3, PricingInformation4, termsConditionText, customsiteAdminEmail, googleAnalyticsID, includeUnitPrice, Instagram, PricingInformation5, PricingInformation6, PricingInformation7, PricingInformation8, PricingInformation9, PricingInformation10  ) 
        SELECT CustomerNumber, CompanyTag, Live, BackgroundColour, Phone, Email, Address, Twitter, Facebook, LinkedIn, Skype, GooglePlus, headerBackground, headerTrimColour, headerTextColour, searchBoxColour, searchBoxTextColour, CategoryIconOverlay, categoryTextColour, paragraphTextColour, tabColour, tabTextColour, tabTextColourHover, tabSelectedColour, tabSelectedText, tableBorderColour, tableHeaderColour, tableHeaderTextColour, tableCellColour, tableCellTextColour, menuHighlightColour, textHighlightColour, menuHoverBackground, ContactUsText, AboutUsText, AdditionalInformation, Q1Markup, Q2Markup, Q3Markup, Q4Markup, Q5Markup, SetupMarkup, BrandingPriceMarkup, showPricing, allowMOQ, MOQSurcharge, PricingInformation1, PricingInformation2, PricingInformation3, PricingInformation4, termsConditionText, customsiteAdminEmail, googleAnalyticsID, includeUnitPrice, Instagram, PricingInformation5, PricingInformation6, PricingInformation7, PricingInformation8, PricingInformation9, PricingInformation10   
        FROM ".$customSite." 
        WHERE  CustomerNumber = '".$custNumber."' AND themeID = '".$themeID."' ";
        $stmt = $conn ->prepare($command); 
        $done = $stmt->execute();  

        if($done){
            echo $conn->lastInsertId();   
        }
        
        
    }

    if($request->option == 7){ 
       //echo "Eto yung theme loops";
       $themeID = $request->themeID; 
       $CompanyTag = $request->CompanyTag; 
       $Live = $request->Live;  
       $BackgroundColour = $request->BackgroundColour;
       $Phone = $request->Phone;
       $Email = $request->Email;
       $DisplayEmail = $request->DisplayEmail;
       $ContactUsActive = $request->ContactUsActive;
       $EnquiryFormActive = $request->EnquiryFormActive;
       $Address = htmlspecialchars($request->Address, ENT_QUOTES);
       $Twitter = $request->Twitter;
       $Facebook = $request->Facebook;
       $LinkedIn = $request->LinkedIn;
       $Skype = $request->Skype;
       $GooglePlus = $request->GooglePlus;
       $Website = $request->Website;
       $headerBackground = $request->headerBackground;
       $headerTrimColour = $request->headerTrimColour;
       $headerTextColour = $request->headerTextColour;
       $searchBoxColour = $request->searchBoxColour;
       $searchBoxTextColour = $request->searchBoxTextColour;
       $CategoryIconOverlay = $request->CategoryIconOverlay;
       $categoryTextColour = $request->categoryTextColour;
       $paragraphTextColour = $request->paragraphTextColour;
       $tabColour = $request->tabColour;
       $tabTextColour = $request->tabTextColour;
       $tabTextColourHover = $request->tabTextColourHover;
       $tabSelectedColour = $request->tabSelectedColour;
       $tabSelectedText = $request->tabSelectedText;
       $tableBorderColour = $request->tableBorderColour;
       $tableHeaderColour = $request->tableHeaderColour;
       $tableHeaderTextColour = $request->tableHeaderTextColour;
       $tableCellColour = $request->tableCellColour;
       $tableCellTextColour = $request->tableCellTextColour;
       $menuHighlightColour = $request->menuHighlightColour;
       $textHighlightColour = $request->textHighlightColour;
       $menuHoverBackground = $request->menuHoverBackground;
       $ContactUsText = htmlspecialchars($request->ContactUsTextEditor, ENT_QUOTES);
       $AboutUsText =   htmlspecialchars($request->AboutUsTextEditor, ENT_QUOTES);
       
       $AdditionalInformation = $request->AdditionalInformation;
       $Q1Markup = $request->Q1Markup;
       $Q2Markup = $request->Q2Markup;
       $Q3Markup = $request->Q3Markup;
       $Q4Markup = $request->Q4Markup;
       $Q5Markup = $request->Q5Markup;
       $Q6Markup = $request->Q6Markup; 
       $SetupMarkup = $request->SetupMarkup;
       $BrandingPriceMarkup = $request->BrandingPriceMarkup;
       $showPricing = $request->showPricing;
       $allowMOQ = $request->allowMOQ;
       //$MOQSurcharge = $request->MOQSurcharge;
       $PricingInformation1 = $request->PricingInformation1;
       $PricingInformation2 = $request->PricingInformation2;
       $PricingInformation3 = $request->PricingInformation3;
       $PricingInformation4 = $request->PricingInformation4;
       $termsConditionText = htmlspecialchars($request->termsConditionTextEditor, ENT_QUOTES);
       $customsiteAdminEmail = $request->customsiteAdminEmail;
       $googleAnalyticsID = $request->googleAnalyticsID;
       $includeUnitPrice = $request->includeUnitPrice;
       $Instagram = $request->Instagram;
       $PricingInformation5 = $request->PricingInformation5;
       $PricingInformation6 = $request->PricingInformation6;
       $PricingInformation7 = $request->PricingInformation7;
       $PricingInformation8 = $request->PricingInformation8;
       $PricingInformation9 = $request->PricingInformation9;
       $PricingInformation10 = $request->PricingInformation10;
       $gmailAccount = $request->gmailAccount;

       if($allowMOQ == 1){
           if($request->MOQSurcharge == ""){
                $request->MOQSurcharge = "";
           }
            $MOQSurcharge = $request->MOQSurcharge;
       }else{
            $MOQSurcharge = null;
       }  

       //Domain
       $Domain = $request->Domain;
       if($Domain){
            $Domain = $Domain;
       }else{
            $Domain = "";
       }
 
 
        $sql = "UPDATE ".$customSite." SET   CompanyTag = '".$CompanyTag."', Live = '".$Live."', BackgroundColour = '".$BackgroundColour."', Domain = '".$Domain."', 
        Phone = '".$Phone."', Email = '".$Email."', Address = '".$Address."', Twitter = '".$Twitter."', Facebook = '".$Facebook."', LinkedIn = '".$LinkedIn."', Skype = '".$Skype."', GooglePlus = '".$GooglePlus."', Instagram = '".$Instagram."', Website = '".$Website."',
        headerBackground ='".$headerBackground."', headerTrimColour ='".$headerTrimColour."', headerTextColour ='".$headerTextColour."', searchBoxColour ='".$searchBoxColour."', searchBoxTextColour ='".$searchBoxTextColour."', CategoryIconOverlay ='".$CategoryIconOverlay."', categoryTextColour ='".$categoryTextColour."', paragraphTextColour ='".$paragraphTextColour."', 
        tabColour ='".$tabColour."', tabTextColour ='".$tabTextColour."', tabTextColourHover ='".$tabTextColourHover."', tabSelectedColour ='".$tabSelectedColour."', tabSelectedText ='".$tabSelectedText."', tableBorderColour ='".$tableBorderColour."', tableHeaderColour ='".$tableHeaderColour."', tableHeaderTextColour ='".$tableHeaderTextColour."', tableCellColour ='".$tableCellColour."', tableCellTextColour ='".$tableCellTextColour."', 
        menuHighlightColour ='".$menuHighlightColour."', textHighlightColour ='".$textHighlightColour."', menuHoverBackground ='".$menuHoverBackground."', ContactUsText ='".$ContactUsText."', AboutUsText ='".$AboutUsText."', AdditionalInformation ='".$AdditionalInformation."', termsConditionText ='".$termsConditionText."',
        Q1Markup ='".$Q1Markup."', Q2Markup ='".$Q2Markup."', Q3Markup ='".$Q3Markup."', Q4Markup ='".$Q4Markup."', Q5Markup ='".$Q5Markup."', Q6Markup ='".$Q6Markup."', SetupMarkup ='".$SetupMarkup."', BrandingPriceMarkup ='".$BrandingPriceMarkup."', showPricing ='".$showPricing."', allowMOQ ='".$allowMOQ."', MOQSurcharge ='".$MOQSurcharge."', 
        PricingInformation1 ='".$PricingInformation1."', PricingInformation2 ='".$PricingInformation2."', PricingInformation3 ='".$PricingInformation3."', PricingInformation4 ='".$PricingInformation4."', PricingInformation5 ='".$PricingInformation5."', PricingInformation6 ='".$PricingInformation6."', PricingInformation7 ='".$PricingInformation7."', PricingInformation8 ='".$PricingInformation8."', PricingInformation9 ='".$PricingInformation9."', PricingInformation10 ='".$PricingInformation10."',  
        customsiteAdminEmail ='".$customsiteAdminEmail."', googleAnalyticsID ='".$googleAnalyticsID."', includeUnitPrice ='".$includeUnitPrice."', gmailAccount =  '".$gmailAccount."', DisplayEmail =  '".$DisplayEmail."', ContactUsActive =  '".$ContactUsActive."', EnquiryFormActive =  '".$EnquiryFormActive."'
        WHERE  themeID ='".$themeID."'";
        $update = $conn->query($sql);  

         

        if($update){
            echo "1";
        }   

    }



    
    if($_POST['options'] == 8){ 

        $bannerData = $_POST['bannerData']; 
        $uid = uniqid();
        $filenameFull = $uid.".jpg";
        $image0 = new \claviska\SimpleImage();
        

        if(!empty($_FILES))  
        {  
            /* print_r($_FILES);
            print_r($bannerData);
            echo $filenameFull. " / ";
            echo $bannerData['ThemeIDUrl']; */
            

            
                $serverPath = $_SERVER['DOCUMENT_ROOT']; 
                $pathVisualUrl = $serverPath.'/Images/Banners/SkinnedSite/'; 
                
                $filenameTemp = $_FILES['tmp_name'];
                $filename = $_FILES['name'];
     
                if (!file_exists($pathVisualUrl.$bannerData['ThemeIDUrl'])) {
                    mkdir($pathVisualUrl.$bannerData['ThemeIDUrl'], 0777, true);
                } 
                $uploaddir1 = $pathVisualUrl.$bannerData['ThemeIDUrl'].'/';
                $uploaddir2 = $pathVisualUrl.$bannerData['ThemeIDUrl'].'/';
                move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir1."!".$filenameFull); 
                $image0->fromFile($uploaddir1."!".$filenameFull);
                $image0->resize(1920,450);
                $image0->toFile($uploaddir1.$filenameFull);
                unlink($uploaddir2."!".$filenameFull);


                $url = $bannerData['url'];
                $active = checkValueYesNo($bannerData['active']);
                $main = checkValueYesNo($bannerData['main']);
                $popup = checkValuePopup($bannerData['popup']); 
                
                $sql = $conn->prepare("INSERT INTO ".$banner_table." (filename, url, location, orderNum, active, main, popup ) VALUES (?, ?, ?, ?, ?, ?, ?)"); 
                $insertFirstImage = $sql->execute(array($filenameFull, $url, $bannerData['ThemeIDUrl'], 0, $active, $main, $popup ));  

                $results = 1; 
                 
                $someJSON = json_encode($results);
                echo $someJSON; 
           

        }
    }


    if($request->option == 9){
        $updateData = $request->updateData;
        $location = $request->location; 
 
        $locationNew = $location;

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

                $sqlB = "UPDATE ".$banner_table." SET  orderNum ='" .$x. "', url ='" .$url. "', active ='" .$active. "', main ='" .$main. "',  
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

    if($request->option == 10){
        $id = $request->id; 
        $filename = $request->filename; 
        $location = $request->location;

        $serverPath = $_SERVER['DOCUMENT_ROOT']; 
        $pathVisualUrl = $serverPath.'/Images/Banners/SkinnedSite/'; 
      
        $imageFile =  $location."/".$filename;
        $command = " DELETE FROM ".$banner_table." WHERE  id= '".$id."'   ";
        $stmt = $conn ->prepare($command); 
        $done = $stmt->execute(); 
 
        if($done){
             unlink($pathVisualUrl.$imageFile);
        }  
        echo "success";  
 
     }


    function cleanValue($Val){
        $newVal = htmlspecialchars($Val, ENT_QUOTES); 
        return $newVal;
    }

    
    function cleanValue2($Val){
        //$newVal = htmlspecialchars($Val, ENT_QUOTES); 
        $res = $Val;
 
		$specChars = array(
			'!' => '',    '"' => '',
			'#' => '',    '$' => '',    '%' => '',
			'&amp;' => '',    '\'' => '',   '(' => '',
			')' => '',    '*' => '',    '+' => '',
			',' => '',    '₹' => '',    '.' => '',
			'/-' => '',    ':' => '',    ';' => '',
			'<' => '',    '=' => '',    '>' => '',
			'?' => '',    '@' => '',    '[' => '',
			'\\' => '',   ']' => '',    '^' => '',
			'_' => '',    '`' => '',    '{' => '',
			'|' => '',    '}' => '',    '~' => '',
			'-----' => '-',    '----' => '-',    '---' => '-',
			'/' => '',    '--' => '-',   '/_' => '-',  '&039'=> '',
            '&039;'=>'', 'â€”' => '', '—' => '-', 'ê'=> 'ê', 'é'=> 'é' 
            
			
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
        }
         
        return $res;
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
