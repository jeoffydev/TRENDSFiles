<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Angular extends CI_Controller {
 

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('home_model');  
		$this->load->model('general_model'); 
		$this->load->helper('download');
		$this->load->model('api_model'); 
		$this->load->model('customsite_model');  
		$this->load->model('skinneduser_model');
		$this->load->model('resetuser_model');
		$this->load->model('checkip_model'); 
		$this->load->model('productsdisplay_model');
		$this->load->library('simpleimage');  
		$this->load->library('phpico'); 
		$this->load->model('category_model'); 
		$this->load->model('favourites_model'); 
		$this->load->model('contact_model');
		$this->load->model('item_model');  
		$this->load->model('usermaintenance_model');
		$this->load->model('dashboard_model');
		
		$this->siteLogcheck = $this->general_model->getLogcheck();  

		
	}

	 
	public function  AngularPost(){
		
		

		$request=$this->request();  

		if($this->input->post('option') == 12){
			$userID= $this->input->post('userID');
			$file = $_FILES['file'];

			$results = $this->general_model->uploadArtworkFile($userID, $file);
			echo $results;

		}else{	 

			/* Request post */

				if($request->option == 2){ 
					$username = $request->username;
					$results = $this->general_model->getUsername($username);
					$someJSON = json_encode($results);
					echo $someJSON;   
				}
	
				if($request->option == 3){ 
					$userN = stripslashes($request->userN);
					$passW = stripslashes($request->passW); 
		
					
					$results = $this->general_model->checkLogin($userN);
					if($results){
						foreach ($results as $res){
							$storedHash =  $res->userHash; 
							$checkNewHash =  hash('sha256',$passW.$res->userSalt); 
							$CustomerOnHold = $res->CustomerOnHold;
							$userID = $res->userID;
							if(($storedHash == $checkNewHash) && ($CustomerOnHold == "N")) {  

									//if jeoffyh@tuapeka.co.nz 
									if($res->userEmail == 'jeoffyh@tuapeka.co.nz'){
										$dataEmail = array(
											'Name' => 'Check and test',
											'Email' => 'jeoffytuapeka@gmail.com',
											'Phone' => '000111',
											'Details' => 'Jeoffy is checking now',
											'emailTo' => 'jeoffyh@tuapeka.co.nz',
											'infoEmail' => 'info@trendscollection.co.nz' 
										);
										//$sendEmail = $this->contact_model->sendContactForm($dataEmail);
									}

									//Remove first the user country Access
									delete_cookie("user_countryAccess");  

									//User Avail Access Country
									$pricey = $res->Currency;
									if($pricey == 'NZD'){
										$currentCountry = $this->checkip_model->processAvail('nz');  
									}
									if($pricey == 'AUD'){
										$currentCountry = $this->checkip_model->processAvail('au'); 
									} 
									//Set cookie
									$this->checkip_model->userCountryCookie($currentCountry);

									$expire=time()+60*60*24*30;
									//$expire=time()+ (60 * 3);
									$encrypt = $this->general_model->getEncrypt($userID);   
									$cookie= array(
										'name'   => 'user_cookies',
										'value'  => $encrypt,
										'expire' => $expire,
									);
									$this->input->set_cookie($cookie); 

									$results = "1";

							}elseif(($storedHash == $checkNewHash) && ($CustomerOnHold == "Y")) {  
									$results = "2";
							}else{
									$results = "0";
							}
							 
						}
							
						echo $results;    
					}  
				} 
		
				if($request->option == 4){ 
					
					//$this->session->sess_destroy(); 
					delete_cookie("user_cookies"); 
					delete_cookie("user_countryAccess"); 
					delete_cookie("switchaccount_cookies"); 
					delete_cookie("switchaccountid_cookies"); 
				 
					echo "1";    
				} 
		
				if($request->option == 6){  
					$customerNumber = $request->customerNumber; 
					$passWord = $request->passWord;
					$themeID = $request->themeID;
					$userName = $request->userName;
		
					$data= array(
						'customerNumber' => $customerNumber, 
						'passWord' => $passWord,
						'themeID' => $themeID,
						'userName' => $userName
					); 
					$results = $this->general_model->verifySkinnedLogin($data);
					//print_r($results);
					if($results['skinnedLoginStatus'] == 1){
						$skinnedUserID = $results['skinnedLoginData'][0]->skinnedUserID;
									$expire=time()+60*60*24*30; 
									$encrypt = $this->general_model->getEncrypt($skinnedUserID);   
									$cookie= array(
										'name'   => 'skinnedUser_cookies',
										'value'  => $encrypt,
										'expire' => $expire,
									);
									$this->input->set_cookie($cookie);  
					} 
					echo $results['skinnedLoginStatus'];    
				}
		
				if($request->option == 7){ 
					//$this->session->sess_destroy(); 
					delete_cookie("skinnedUser_cookies"); 
					echo "1";    
				} 

				//Authorized 
				if($this->siteLogcheck['userDatas'][0]->userID){


					if($request->option == 8){
						$userNameEmail = $request->userNameEmail;
						$themeID = $request->themeID;
						$customerNumber = $request->customerNumber;
						$data= array(
							'customerNumber' => $customerNumber,  
							'themeID' => $themeID,
							'userNameEmail' => $userNameEmail
						); 
						$results = $this->general_model->verifyForgotPassword($data);
						echo $results;
						
					}
	
					
			
					if($request->option == 9){ 
						$userID = $request->userID;
						$visualUser = array();
						$visualUser['visualRequests'] = $this->general_model->checkVisualsUserRequest($userID); 
						$visualUser['visualFiles'] = $this->general_model->checkVisualsFiles($userID);
						$visualUser['visualProductVisualLists'] = $this->general_model->getProductsVisualList();
						if(count($visualUser['visualRequests']) > 0){
							$visualUser['visualRequests'] = $visualUser['visualRequests'];
						}else{
							$visualUser['visualRequests'] = 0; 
						}
			
						if(count($visualUser['visualFiles']) > 0){
							$visualUser['visualFiles'] = $visualUser['visualFiles'];
						}else{ 
							$visualUser['visualFiles'] = 0;
						}
						
						
						//echo $visualFiles;
						$someJSON = json_encode($visualUser);
						echo $someJSON;  
					}
			
					if($request->option == 10){ 
						$userID = $request->userID;
						$visualFiles = $request->visualFiles;
						$results = array();
						$results['deleted'] = $this->general_model->deleteArtworkFile($userID, $visualFiles);
						$countMe = $this->general_model->checkVisualsFiles($userID);
						$results['countFiles'] = count($countMe);
			
						$someJSON = json_encode($results);
						echo $someJSON;  
					}
			
					if($request->option == 11){ 
						$userID = $request->userID;
						$projectName = $request->projectName;
						$instructions = $request->instructions;
						$results = $this->general_model->updateProjectDetails($userID, $projectName, $instructions);
			
						echo $results;
					}
	
					if($request->option == 12){ 
						$itemCode = $request->itemCode; 
						$results = $this->general_model->getTheItemColours($itemCode);
						$someJSON = json_encode($results);
						echo $someJSON;  
					}
	
					if($request->option == 13){ 
						$userID = $request->userID; 
						$projectName = @trim(stripslashes($request->projectName));
						$instructions = @trim(stripslashes($request->instructions));
						$productItem = $request->productItem;
						$ItemColour = @trim(stripslashes($request->ItemColour));
						$BrandingOption = @trim(stripslashes($request->BrandingOption));
						$BrandingPosition = @trim(stripslashes($request->BrandingPosition));
						$PrintColours = @trim(stripslashes($request->PrintColours));
						$ItemInstructions = @trim(stripslashes($request->ItemInstructions));
						$visualType = @trim(stripslashes($request->VisualType));
	
						$data = array(
							'userID' => $userID, 
							'projectName' => $projectName,
							'instructions' => $instructions,
							'productItem' => $productItem,
							'ItemColour' => $ItemColour,
							'BrandingOption' => $BrandingOption,
							'BrandingPosition' => $BrandingPosition,
							'PrintColours' => $PrintColours,
							'ItemInstructions' => $ItemInstructions,
							'VisualType' =>$visualType 
						);
	
						$results = $this->general_model->saveToVisuals($data);
						$someJSON = json_encode($results);
						echo $someJSON;  
					}
	
					if($request->option == 14){ 
						$uid = $request->uid; 
						$results = $this->general_model->deleteItemVisuals($uid);
						$someJSON = json_encode($results);
						echo $someJSON;  
					}
	
					if($request->option == 15){ 
						$uid = $request->uid;
						$cols  = $request->cols;
						$details  = $request->details;
	
						$results = $this->general_model->updateVisualItems($uid, $cols, $details);
						$someJSON = json_encode($results);
						echo $someJSON;  
					}
	
					if($request->option == 16){ 
						$userID = $request->userID;
						$visualForm = $request->visualForm;
	
						$results = $this->general_model->sendEmailToVisuals($userID, $visualForm);
						$someJSON = json_encode($results);
						echo $someJSON;  
					}

					if($request->option == 18){ 
						//Check if the user is logged in and get the userID from the sitelogcheck
						if($this->siteLogcheck['userDatas'][0]->userID){
							$userID = $this->siteLogcheck['userDatas'][0]->userID;
							$userEmail = $this->siteLogcheck['userDatas'][0]->userEmail;
							$pw1 = $request->pw1;
							$pw2 = $request->pw2;
							$seaSalt = $request->seaSalt;
							$results = 0;
							$data = array(
								'userID' => $userID,
								'userEmail' => $userEmail,
								'pw1' => $pw1,
								'pw2' => $pw2,
								'seaSalt' => $seaSalt
							);
							if($pw1 == $pw2){
								$results = $this->general_model->updateUserPW($data);
							}
							$someJSON = json_encode($results);
							echo $someJSON;  

						}  
					}
	

				} //Authorized 
				
				//Password reset here
					if($request->option == 17){ 
						$oldpw = $request->oldpw;
						$seaSalt = $request->seaSalt;
						$userEmail = $request->userEmail;
						$results = 0;
	
						if($seaSalt && $userEmail){
	
							$results = $this->general_model->checkLogin($userEmail);
							if($results){
								foreach ($results as $res){
									$storedHash =  $res->userHash; 
									$checkNewHash =  hash('sha256',$oldpw.$res->userSalt); 
									if($storedHash == $checkNewHash){
										$results = 1;
									}else{
										$results = 2;
									}   
								} 	
								
							}  
							
						}
	
	
						$someJSON = json_encode($results);
						echo $someJSON;  
					}
	
					
	
					if($request->option == 19){
						$userNameEmail = $request->userNameEmail;
						 
						$data= array( 
							'userNameEmail' => $userNameEmail
						); 
						$results = $this->resetuser_model->verifyMainUserEmailForgot($data);
						echo $results;
						
					}
	
					if($request->option == 20){ 
							$userID = $request->userID; 
							$userHash = $request->userHash; 

							//Verify first using the userID and pwReset hash generated
							$success = $this->resetuser_model->verifyHash($userHash); 
							if($success['confirmed'] > 0  &&  $success['userID'] ){
								$pw1 = $request->pw1;
								$pw2 = $request->pw2; 
								
								$data = array(
									'userID' => $userID,
									'userEmail' => null,
									'pw1' => $pw1,
									'pw2' => $pw2, 
								);
								if($pw1 == $pw2){
									$results = $this->general_model->updateUserPW($data);
								}
								$someJSON = json_encode($results);
								echo $someJSON;  
							} 
					}

				
					 
		
				
				


			/* Request post */

		}
		
		

		

	}

	public function  homeAngularPost(){
		
		$request=$this->request(); 
		if($request->option == 1){ 
			$results = $this->home_model->getFeaturedItems();
			$someJSON = json_encode($results);
			echo $someJSON;  
			 
		} 
	}
 

	public function  productapiAngularPost(){  
		$request=$this->request();  
		$userID= $request->userID;
		if($request->option == 1){ 
			 $results = $this->api_model->updateAPiRequest($userID);
			 if($results){
				 echo "1";
			 }
		} 

	}

	public function  customsiteAngularPost(){

		if($this->input->post('options') == 7){
		 
			$serverPath = $_SERVER['DOCUMENT_ROOT']; 
			$pathLogoUrl = $serverPath.'/Images/TopMenu/customerLogos/'; 
			

			$themeID = $this->input->post('themeID');

			if($_FILES['file']['error'] === UPLOAD_ERR_OK) {  

				//print_r($this->simpleimage());
					//print_r($_FILES["file"]); 
					//print_r($this->input->post());   
				
					if($this->input->post('opts') == 1){
						
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
							
						
							
							$this->simpleimage->fromFile($pathLogoUrl."!".$filenameFull);
							$this->simpleimage->bestFit(700,87);
							$this->simpleimage->toFile($pathLogoUrl.$filenameFull);

							
							unlink($_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/!".$filenameFull);
							
							echo "1";  
					} 

					if($this->input->post('opts') == 2){

            
					 
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
						 
						//$this->load->library('phpico', $config);
						//$this->load->library('phpico'); 
						$this->phpico->index($source, $sizes); 
						$this->phpico->save_ico( $destination );  
						unlink($_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/favicon/!".$themeID.".".$Fextension2);
		
						echo "1";  
						
				   }
				



			}   




		}else{

			$request=$this->request();  
			$option = $request->option;

			if($option == 1){
				$CustomerNumber = $request->customerNumber;
				$results = $this->customsite_model->getMainCustomer($CustomerNumber); 
				$someJSON = json_encode($results);
				echo $someJSON; 
			}

			if($option == 2){

				$selectedThemeID = $request->selectedThemeID;
				$results = $this->customsite_model->getThemeData($selectedThemeID);
				//print_r($results);
				$results[0]->AboutUsTextNew  = htmlspecialchars_decode($results[0]->AboutUsText);
				$results[0]->ContactUsTextNew  = htmlspecialchars_decode($results[0]->ContactUsText);
				$results[0]->termsConditionTextNew  = htmlspecialchars_decode($results[0]->termsConditionText);

				$Exist = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$selectedThemeID.".jpg";
				$Exist2 = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$selectedThemeID.".png";
				$Exist3 = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/".$selectedThemeID.".gif";
				$ExistFavicon = $_SERVER['DOCUMENT_ROOT']."/Images/TopMenu/customerLogos/favicon/".$selectedThemeID.".ico";

				if(file_exists($Exist)) { 
					$results[0]->LogoExist  = 1;
					$results[0]->LogoUrl = "/Images/TopMenu/customerLogos/".$selectedThemeID.".jpg";
				}elseif(file_exists($Exist2)) { 
					$results[0]->LogoExist = 1;
					$results[0]->LogoUrl = "/Images/TopMenu/customerLogos/".$selectedThemeID.".png";
				}elseif(file_exists($Exist3)) { 
					$results[0]->LogoExist = 1;
					$results[0]->LogoUrl = "/Images/TopMenu/customerLogos/".$selectedThemeID.".gif";
				}else{ 
					$results[0]->LogoExist = 0;
					$results[0]->LogoUrl = 0;
				}
		
				if(file_exists($ExistFavicon)) {
					$results[0]->FaviconExist = 1;
					$results[0]->FaviconUrl = "/Images/TopMenu/customerLogos/favicon/".$selectedThemeID.".ico";
				}else{
					$results[0]->FaviconExist = 0;
					$results[0]->FaviconUrl = 0;
				}  

				$someJSON = json_encode($results[0]);
				echo $someJSON; 

			}

			if($option == 3){
				$newTheme = $request->newTheme;
				$customerNum = $request->customerNum; 
				$results = $this->customsite_model->insertNewTheme($newTheme, $customerNum);
				echo $results; 
			}

			if($option == 4){ 
				$CustomerNumber = $request->customerNumber; 
				$CustomerName = $request->customerName;
				$themeMax  = $request->themeMax;
				$results = $this->customsite_model->getCustomersTheme($CustomerNumber, $CustomerName, $themeMax);
				$someJSON = json_encode($results);
				echo $someJSON; 
			}

			if($option == 5){ 
				$selectedThemeID = $request->selectedThemeID; 
				$customerNumber = $request->customerNumber;
				$results = $this->customsite_model->deleteTheme($selectedThemeID, $customerNumber);
				echo $results;
			}


			if($option == 6){  
				$results = $this->customsite_model->updateTheme($request);
				echo $results;
			}

		}
		

		
		  
	}


	public function  skinneduserAngularPost(){

		if(!$this->siteLogcheck['userDatas'][0]->userID)
			return $this->general_model->UnAuthorized();

			
		$request=$this->request();  
		$option = $request->option;

		if($option == 1){ 
			$CustomerNumber = $request->customerNumber;  
			$results = $this->skinneduser_model->getskinCustomersTheme($CustomerNumber);
			$someJSON = json_encode($results);
			echo $someJSON; 
			
		}

		if($option == 2){ 
			$selectedThemeID = $request->selectedThemeID;
			$customerNumber = $request->customerNumber;
			$results = $this->skinneduser_model->getskinUserData($selectedThemeID, $customerNumber);
			$someJSON = json_encode($results);
			echo $someJSON; 
		}

		if($option == 3){ 

			$email = $request->email;
			$ThemeID = $request->ThemeID;
			$customerNumber = $request->customerNumber;
			$results = $this->skinneduser_model->checkEmailIfExists($email, $ThemeID, $customerNumber);
			$someJSON = json_encode($results);
			echo $someJSON; 
		}

		if($option == 4){ 
			$skinnedName = $request->skinnedName;
			$skinnedCompany = $request->skinnedCompany;
			$skinnedEmail = $request->skinnedEmail;
			$themeID = $request->themeID;
			$customerNumber = $request->customerNumber;
			$baseUrlDomain = $request->baseUrl;

			$results = $this->skinneduser_model->addNewSkinUser($skinnedName, $skinnedCompany, $skinnedEmail, $themeID, $customerNumber, $baseUrlDomain);
			$someJSON = json_encode($results);
			echo $someJSON; 

		}

		if($option == 5){ 
			$skinnedUserID = $request->skinnedUserID;
			$results = $this->skinneduser_model->deleteSkinUser($skinnedUserID);
			$someJSON = json_encode($results);
			echo $someJSON;  
		}

		if($option == 6){ 
			$skinnedUserID = $request->skinnedUserID; 
			$skinEmail = $request->skinEmail;  
			$opts = $request->opts;
			$dataUser = array(
				'id' => $skinnedUserID,  
				'skinEmail' => $skinEmail 
			);  
			
			
			//print_r($results);
			if($opts == 1){
				$results = $this->skinneduser_model->viewSelectPassword($skinnedUserID); 
				foreach($results as $post) {
					$resultsArray =  $post->skinnedPwReset;
				} 

			}else{ 
				$reset =  $this->skinneduser_model->updateResetPw($dataUser);
				if($reset){
					$results = $this->skinneduser_model->viewSelectPassword($skinnedUserID); 
					foreach($results as $post) {
						$resultsArray =  $post->skinnedPwReset;
					} 
					 
					//$resultsArray  = $results->skinnedPwReset;
					//print_r($resultsArray);
				}  
			} 
			//$someJSON = json_encode($resultsArray); 
			echo $resultsArray;  
		}

	}

	public function  usermaintenanceAngularPost(){

		if(!$this->siteLogcheck['userDatas'][0]->userID  )
			return $this->general_model->UnAuthorized();

			
		$request=$this->request();  
		$option = $request->option;

		//Authorization - only TGP account can edit and access this request
		if($this->siteLogcheck['userDatas'][0]->CustomerNumber == '10105'){ 
			if($option == 1){  
					$customerNumber = $request->customerNumber; 
					$results = $this->usermaintenance_model->getCustomerClients($customerNumber);
					$someJSON = json_encode($results);
					echo $someJSON;   
			}
	
			if($option == 2){
				$newSalt = $this->general_model->grind_salt(); 
				$adminEmail =  $request->userAdminEmail;  
				$newUserEmail = $request->userEmail;
				$customerNumber = $request->customerNumber;
	
				$data = array(
					'newSalt' => $newSalt,
					'adminEmail'=> $adminEmail,
					'newUserEmail'=> $newUserEmail,
					'customerNumber'=>$customerNumber
				);
	
				$results = $this->usermaintenance_model->insertNewTrendUser($data);
				$someJSON = json_encode($results);
				echo $someJSON; 
			}
	
			if($request->option == 3){ 
				$userID =  $request->customerID;
				$results = $this->usermaintenance_model->deleteUser($userID); 
	
				echo $results;
			}
	
			if($request->option == 4){ 
				$userID= $request->userID;
				$hash = $request->hash;
				$userCustNum = $request->userCustNum;
				
				$data = array(
					'userID' => $userID,
					'hash'=> $hash, 
					'userCustNum'=>$userCustNum
				);
	
				$results = $this->usermaintenance_model->getHashUser($data); 
				$someJSON = json_encode($results);
				echo $someJSON;   
			}
	
	
			if($request->option == 6){ 
				$userID= $request->userID;
				$customerNumbered = $request->customerNumbered;
	
				$results = $this->usermaintenance_model->getUserID($userID); 
				
				//Get Pages
				$resultPages = $this->usermaintenance_model->getPages(); 
				
				//Get the Main company VisualAccess
				$resultsCompany = $this->usermaintenance_model->getVisualAccess($customerNumbered);  
	
				$results['visualAccessUser'] = $resultsCompany[0]; 
				$results['selectAccess'] = $resultPages; 
				//print_r($results);
				$someJSON = json_encode($results);
				echo $someJSON;   
			}
	
			if($request->option == 7){ 
				$userID= $request->userID;
				$multiCurrency= $request->selectYesNoCurrency;
				//$skinnedWebsites= $request->selectYesNoSkinned;
	
				$data = array(
					'userID' => $userID,
					'multiCurrency'=> $multiCurrency, 
					//'skinnedWebsites'=>$skinnedWebsites
				);
	
				$resultsCompany = $this->usermaintenance_model->updateUserAccess($data);  
	
			} 
		}
		//Authorization - only TGP account can edit and access this request
	}

	public function  resetuserAngularPost(){
		$request=$this->request();  
		$option = $request->option;

		if($option == 1){
			$passwordCheck = $request->passwordCheck;
			$customsiteID = $request->customsiteID;
			$skinnedUserID = $request->skinnedUserID;

			$results = $this->resetuser_model->resetPassword($passwordCheck, $skinnedUserID, $customsiteID); 
			$someJSON = json_encode($results);
			echo $someJSON;  
		}
		

		 
	}


	public function AngularPostQuickView(){
		$request=$this->request();  
		$option = $request->option;
		 
			if($option == 1){
				$opts = $request->opts;
				$prim = $request->prim;
				$code = $request->code;
	
				$loginUser = $request->loginUser;
				$skinnedSite = $request->skinnedSite;
				$skinned = $request->skinned;
				$from = $request->from;
				
				 
	
				$results = $this->productsdisplay_model->quickViewRequest($opts, $prim, $code, $loginUser, $skinnedSite, $skinned, $from);  
				
				
				if($opts == 'stock' || $opts == 'pricing'){
					echo $results;  
				}else{
					$someJSON = json_encode($results);
					echo $someJSON;  
				}
				
			}
			
			if($option == 2){
				$brand = $request->brand;
				$brandingFinal = '';
				$brandingMenu = $this->general_model->getBrandingMenu();
				 
				$brandingMenuCount = count($brandingMenu) - 1;
				for($i = 0; $i <= $brandingMenuCount; $i++){ 
					//echo $brandingMenu[$i]['title']. " / ";
					if($brand == "Screen Print"){
						$brand = "Rotary Screen Print";
					}
					if($brandingMenu[$i]['title'] == $brand){
						$brandingFinal = $brandingMenu[$i]['imgUrl'];
					} 
				}
				
				 
				echo $brandingFinal;
			}

		
			if($option == 3){
				$code = $request->code;
				$name = $request->name;
				$results = $this->productsdisplay_model->getPMSTable($code, $name); 
				$someJSON = json_encode($results);
				echo $someJSON;
			}
		 
		
 

	}

	public function  favouritesAngularPost(){
		$request=$this->request();  
		$option = $request->option;

		if($option == 1){
			$code = $request->code;
			$userID = $request->userID; 
			$results = $this->favourites_model->removeFavourite($code, $userID);
			$someJSON = json_encode($results);
			echo $someJSON;
		}

		if($option == 2){ 
			$userID = $request->userID; 
			//$siteLog = $request->siteLog; 
			$avail = $request->avail; 
			$custom = $request->custom;  
			$customArray = $this->general_model->checkID($custom);
			$results = $this->favourites_model->getFavouritesItems($userID, $this->siteLogcheck, $avail, $customArray);
			$someJSON = json_encode($results);
			echo $someJSON;
		 
		}
		 
	}


	public function AngularPostScrollBottom(){

		$request=$this->request();  
		$option = $request->option;
		$flag = $request->flag;
		$categoryCode = $request->categoryCode; 
		$customID = $request->customID;
		$rowperpage = $request->rowperpage;
		$parameters = $request->parameters;

		$customArray = $this->general_model->checkID($customID);
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		//print_r($customArray);
		//echo $checkAvailCountry;
		$getCategoryProducts = $this->category_model->getCategoryProducts($categoryCode, $this->siteLogcheck, $checkAvailCountry, $customArray, $flag, $rowperpage, $parameters);


		//Cache
		/*
		$this->load->driver('cache', array('adapter'   => 'file')); 
		 
		if($this->siteLogcheck['userDatas'][0]->userID && count($customArray['themeArray'])==0){
			$cacheCategoryItem = $this->siteLogcheck['userDatas'][0]->userID.'_categorycache_'.$categoryCode;  
			 
		}else{
			$cacheCategoryItem = $checkAvailCountry.'_categorycache_'.$categoryCode;  
			if(count($customArray['themeArray']) > 0){ 
				$cacheCategoryItem = $customArray['themeArray'][0]->themeID.'_skinned_categorycache_'.$categoryCode;  
			}
		}

		if(!$getCategoryProducts = $this->cache->get($cacheCategoryItem)){
			$getCategoryProducts = $this->category_model->getCategoryProducts($categoryCode, $this->siteLogcheck, $checkAvailCountry, $customArray, $flag, $rowperpage, $parameters);
			$this->cache->save($cacheCategoryItem, $getCategoryProducts, 1800);  
		} */
		//Cache




		//GET Cache --------------------------------------------------------------- NOTE ------------------------------------------------
			 //print_r($parameters);

			/**************************!IMPORTANT - BASED ON Category Model CACHE **********************************/
			$this->load->driver('cache', array('adapter'   => 'file')); 

			if($parameters->lowPrice == 0){
				$parameters->lowPrice = "";
				$parameters->highPrice = "";
			}
			if($parameters->stockNumber == 0){
				$parameters->stockNumber = "";
			}
			 
			if(!$parameters->Branding && !$parameters->keyword && !$parameters->Colours  && !$parameters->stockNumber && !$parameters->lowPrice && !$parameters->highPrice && !$parameters->priceSort && $flag == 0 ){ 
				
				 
				/* if($this->siteLogcheck['userDatas'][0]->userID && count($customArray['themeArray'])==0){
					$cacheCategoryItems = $this->siteLogcheck['userDatas'][0]->userID.'_categorycacheItems'.$categoryCode; //."_".$parameters->Branding."".$parameters->keyword."".$parameters->Colours."".$parameters->stockNumber."".$parameters->lowPrice."".$parameters->highPrice."".$parameters->priceSort;  
					
				}else{
					$cacheCategoryItems = $checkAvailCountry.'_categorycacheItems'.$categoryCode; //."_".$parameters->Branding."".$parameters->keyword."".$parameters->Colours."".$parameters->stockNumber."".$parameters->lowPrice."".$parameters->highPrice."".$parameters->priceSort;   
					if(count($customArray['themeArray']) > 0){ 
						$cacheCategoryItems = $customArray['themeArray'][0]->themeID.'_skinned_categorycacheItems'.$categoryCode; //."_".$parameters->Branding."".$parameters->keyword."".$parameters->Colours."".$parameters->stockNumber."".$parameters->lowPrice."".$parameters->highPrice."".$parameters->priceSort;    
					}
				}
			 
				if($this->cache->get($cacheCategoryItems)){ 
					$getCategoryProducts['categories'] = $this->cache->get($cacheCategoryItems); 
					//$this->cache->save($cacheCategoryItems, $getCategoryProducts['categories'], 1800);  
				} */
				//print_r($getCategoryProducts['categories']);

			}
			/**************************!IMPORTANT - BASED ON Category Model CACHE **********************************/
		//GET Cache --------------------------------------------------------------- NOTE ------------------------------------------------
 
		if($option == 1){
			  
			
			if($customArray['themeArray'][0]->showPricing == 2){
				$CustomerNumber = $customArray['themeArray'][0]->CustomerNumber;
				$themeID = $customArray['themeArray'][0]->themeID;
				$skinnedUserCheck = $this->skinnedSiteLogcheck = $this->general_model->getSkinnedLogcheck($CustomerNumber, $themeID);  
			}else{
				$skinnedUserCheck = null;
			} 
		 
			//$json_data=array('categoriesAllCount' => $getCategoryProducts['categoriesAllCount']);
			$json_data=array();
			foreach($getCategoryProducts['categories'] as $rec)//foreach loop  
			{    
				
				$json_array = $this->productsdisplay_model->productsLoop($rec, $this->siteLogcheck, $customArray, $skinnedUserCheck); 
				
				$json_array['Name'] = $this->general_model->cleanString($json_array['Name'], 1); 
				$json_array['FullName'] = $this->general_model->cleanString($json_array['FullName']); 
				 
				array_push($json_data,$json_array);
			} 
			//print_r( $json_data );
			echo json_encode($json_data,JSON_PRETTY_PRINT);  

			 
			 
			

		}

		if($option == 2){
			echo  $getCategoryProducts['categoriesAllCount'];
		}
	}

	

	public function FavouriteItem(){ 

		if(!$this->siteLogcheck['userDatas'][0]->userID)
			return $this->general_model->UnAuthorized();
		  
			//$this->siteLogcheck
			$request=$this->request(); 
			$option = $request->option; 
			$Code = $request->Code; 

			//Check first if user is loggedin
			if($userID = $this->siteLogcheck['userDatas'][0]->userID){
				if($option == 1){ 
					$check = $this->favourites_model->checkFavourite($userID, $Code);
					echo $check;
				}
		
				if($option == 2){ 
					$addFav= $this->favourites_model->addFavourite($userID, $Code);
					echo $addFav;
				}
		
				if($option == 3){
					$remFav= $this->favourites_model->removeFavourite($Code, $userID);
					echo $remFav;
				}
			} 

		
	}

	public function enquiryForm(){ 
		$request=$this->request(); 
		$option = $request->option;
		

		if($option == 1){
			if($request->Human == true && $request->BotValue == 1 && $request->Name && $request->Email && $request->Phone){ 
					$Code = $request->Code;
					$Name = @trim(stripslashes($request->Name));
					$Company = @trim(stripslashes($request->Company));
					$Email = @trim(stripslashes($request->Email));
					$Phone = @trim(stripslashes($request->Phone));
					$Product = @trim(stripslashes($request->Product));
					$Details = @trim(stripslashes($request->Details)); 
					$emailTo = $request->emailTo;
					$skinnedDomain = $request->skinnedDomain;

					$arraySend = array(
						'Code' => $Code,
						'Name'=> $Name,
						'Company'=> $Company,
						'Email'=> $Email,
						'Phone'=> $Phone,
						'Product'=> $Product,
						'Details'=> $Details,
						'emailTo'=> $emailTo,
						'skinnedDomain'=> $skinnedDomain
					);


					$results = $this->contact_model->sendFormEnquiry($arraySend); 
					$someJSON = json_encode($results);
					echo $someJSON;
			}
		}

	}


	public function ContactForm(){ 
		$request=$this->request(); 
		$option = $request->option;
		
		

			if($option == 1){

				if($request->Human == true && $request->BotValue == 1 && $request->Name && $request->Email && $request->Phone){ 
					$Name = @trim(stripslashes($request->Name)); 
					$Email = @trim(stripslashes($request->Email));
					$Phone = @trim(stripslashes($request->Phone)); 
					$Details = @trim(stripslashes($request->Details)); 
					$emailTo = $request->emailTo;
					$infoEmail = $request->infoEmail;
		
					$arraySend = array( 
						'Name'=> $Name, 
						'Email'=> $Email,
						'Phone'=> $Phone, 
						'Details'=> $Details,
						'emailTo'=> $emailTo,
						'infoEmail'=> $infoEmail,
					);

					$results = $this->contact_model->sendContactForm($arraySend); 
					$someJSON = json_encode($results);
					echo $someJSON;
					 

				}
				
			} 
		 

	}

 	//HITPROMO
	public function HitPromoAngularPost(){
		$request=$this->request(); 
		$option = $request->option;
		$hitPromoAPIs = $request->hitPromoAPIs;
		$hitCode = $request->hitCode;

		if($option == 1){
			$results= $this->item_model->getHitPromoAPIDatas($hitPromoAPIs, $hitCode);
			echo $results;
		}
	}


	public function Customer($opt=null, $orderNum=null ){


		if(!$this->siteLogcheck['userDatas'][0]->userID)
			return $this->general_model->UnAuthorized();


		$request=$this->request(); 
		$option = $request->option;

		 
		 

		if($option == 1){
			$jobnumber = $request->jobnumber;

			$results= $this->dashboard_model->ConvertToImage($jobnumber);
			echo $results;
		}

		if($opt == 2){
			$orderNum = $orderNum; 
			//$userID = $request->userID;
			//$comp = $request->comp;
 
 
			 $results= $this->dashboard_model->OrderLines($orderNum); 
			// print_r($results);
			setlocale(LC_MONETARY,"en_NZ");
			$varTable = "";
			$resOrderTable = $results->OrderLinesResult->OrderLines->OrderLine;

			if($resOrderTable->StockCode != ""){
				$varTable  = "<tr><td> " .$resOrderTable->StockCode. " </td><td> " .$resOrderTable->StockDescription.  " </td><td> <span class='qtyorder'>" .round($resOrderTable->Quantity, 0). "</span> </td><td> <span class='priceorder'>" .number_format($resOrderTable->UnitPrice, 2). "</span> </td> <td> <span class='grossorder'>" .number_format($resOrderTable->GrossAmount, 2). "</span> </td></tr>";
			}
			
			//Loop
			if(!$resOrderTable->StockCode){ 
				for($i = 0; $i < count($resOrderTable); $i++){
					$varTable .= "<tr><td> " .$resOrderTable[$i]->StockCode. " </td><td> " .$resOrderTable[$i]->StockDescription.  " </td><td> <span class='qtyorder'>" .round($resOrderTable[$i]->Quantity, 0). "</span> </td><td> <span class='priceorder'>" .number_format($resOrderTable[$i]->UnitPrice, 2). "</span> </td> <td> <span class='grossorder'>" .number_format($resOrderTable[$i]->GrossAmount, 2). "</span> </td></tr>";
				} 
			} 
			$table = ' <table class="table text-left orderlines" ng-if="orderLines">';

			$thead = '<thead><tr><th scope="col"> Code</th><th scope="col">Description</th><th scope="col">Quantity</th><th scope="col"><span class="priceheading">Price $</span></th><th scope="col">Gross Amount $</th></tr></thead>';
			$tbody = '<tbody>  ';

			$tbodyClose = '</tbody>';	     
			$tableClose = '</table>';

			$orderLineTable = $table."".$thead."".$tbody."".$varTable."".$tbodyClose."".$tableClose;
			
			 
			$arrayOrderLines = array(
				'OrderReceived' => $results->OrderLinesResult->OrderReceived,
				'LastProofed' => $results->OrderLinesResult->LastProofed,
				'OrderApproved' => $results->OrderLinesResult->OrderApproved,
				'Dispatched' => $results->OrderLinesResult->Dispatched,
				'OrderLines' =>  $results->OrderLinesResult->OrderLines->OrderLine,
				'OrderTable' => $orderLineTable,
				'Delivered' => $results->OrderLinesResult->Delivered,
				'POD' => $results->OrderLinesResult->POD,
				'Signatory' => $results->OrderLinesResult->Signatory 
			);

			$someJSON = json_encode($arrayOrderLines);
			echo $someJSON;
		}

		if($option == 3){
			$orderNum = $request->orderNum;  
			$userID = $request->userID;
			$comp = $request->comp;

			$resultsCount = $this->dashboard_model->OrderLinesCount($orderNum); 
			echo $resultsCount;

			if($resultsCount > 15){
				//Cache stored
				$this->load->driver('cache', array('adapter'   => 'file')); 
				if($userID && $comp){ 
					$cacheSavedOrderLines = $userID.'_'.$comp.'_'.$orderNum.'_orderlines'; 
				}  
				if(!$results = $this->cache->get($cacheSavedOrderLines)){ 
					$results = $this->dashboard_model->OrderLines($orderNum);  
					$this->cache->save($cacheSavedOrderLines, $results, 1200);
				}
			}

		}

		

		if($option == 4){
			$datas = $request->data;   
			$resultSendRepeat = $this->dashboard_model->SendToDBAndEmail($datas); 
			echo $resultSendRepeat;
		}

		if($option == 5){
			$data = $request->data;   
			$result = $this->dashboard_model->checkOrderRepeat($data, 2); 
			$someJSON = json_encode($result);
			echo $someJSON;
		}


	}


	function request()
    {
        $postdata = file_get_contents("php://input");
		$request = json_decode($postdata); 

		return $request;
    }
	
	
}
