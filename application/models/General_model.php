<?php

require_once APPPATH.'libraries/PHPMailer/PHPMailerAutoload.php';
 
class General_Model extends CI_Model {

	public function __construct(){ 
		parent:: __construct();  
	 
		/* Variables  */
		$this->domainCheck = "0";  
		$this->category = null; 

		$this->load->model('skinneduser_model');
		$this->load->model('checkip_model'); 
		$this->load->library('email');
	}


	function getProductsMenu(){
		$query = $this->db->query("SELECT CategoryName, CategoryNum, CategoryNameProducts FROM categoriesCurrent WHERE CategoryNum NOT LIKE '%-0' AND CategoryNum NOT LIKE '1__-%' AND CategoryNum NOT LIKE '2__-%' AND CategoryDouble = 0 ORDER BY CategoryNameProducts");
		return $query->result();
	}

	function getCollectionsMenu(){
		$query = $this->db->query("SELECT CategoryName, CategoryNum FROM categoriesCurrent WHERE CategoryNum NOT LIKE '%-0' AND CategoryNum LIKE '101-%' ORDER BY CategoryName");
		return $query->result();
	}

	function getPremiumMenu(){ 
		
		$premiumArray  = array(
			 
			array(
				'url' => '103-6', 'title' => 'XD Design'
			),
			array(
				'url' => '103-7', 'title' => 'Swiss Peak'
			),
			array(
				'url' => '103-11', 'title' => 'Pierre Cardin'
			),
			array(
				'url' => '103-12', 'title' => 'Lamy'
			), 
			array(
				'url' => '103-14', 'title' => 'Sol&#39;s'
			),
			array(
				'url' => '103-13', 'title' => 'Moleskine'
			),
			array(
				'url' => '103-15', 'title' => 'Titleist'
			),
			array(
				'url' => '103-16', 'title' => 'BLUNT'
			),
			array(
				'url' => '103-17', 'title' => 'CamelBak'
			),
			array(
				'url' => '103-18', 'title' => 'Peros'
			)      
			     
		);

		return $premiumArray;
	}

	function getWorldSourceMenu(){
		$query = $this->db->query("SELECT CategoryName, CategoryNum FROM categoriesCurrent WHERE CategoryNum LIKE '102-%' ORDER BY CategoryName");
		return $query->result();
	}
	 
	function getPromoShopMenu(){ 
		
		$promoArray  = array(
			array(
				'url' => '100-1', 'title' => 'Pens'
			),
			array(
				'url' => '100-3', 'title' => 'Drinkware'
			),
			array(
				'url' => '100-4', 'title' => 'Key Rings'
			),
			array(
				'url' => '100-5', 'title' => 'Business'
			),
			array(
				'url' => '100-7', 'title' => 'Technology'
			),
			array(
				'url' => '100-6', 'title' => 'Personal'
			),
			array(
				'url' => '100-2', 'title' => 'Promotional'
			)  
		);

		return $promoArray;
	}
 
	function getBrandingMenu(){ 
		
		$brandingArray  = array(
			array(
				'imgUrl' => 'PadPrint', 'title' => 'Pad Print', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'RotaryDigitalPrint', 'title' => 'Rotary Digital Print', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'ScreenPrint', 'title' => 'Rotary Screen Print', 'topMenu' => 1, 'selectOption' => 0
			),
			array(
				'imgUrl' => 'FlatbedScreenPrint', 'title' => 'Flatbed Screen Print', 'topMenu' => 1, 'selectOption' => 0
			),
			array(
				'imgUrl' => 'ScreenPrint', 'title' => 'Screen Print', 'topMenu' => 0, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'ImitationEtch', 'title' => 'Imitation Etch', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'LaserEngraving', 'title' => 'Laser Engraving', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'ResinCoatedFinish', 'title' => 'Resin Coated Finish', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'DigitalTransfer', 'title' => 'Digital Transfer', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'SublimationPrint', 'title' => 'Sublimation Print', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'DigitalMedia', 'title' => 'Digital Print', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'FullColourLabel', 'title' => 'Digital Label', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'DirectDigital', 'title' => 'Direct Digital', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'Debossing', 'title' => 'Debossing', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'Embroidery', 'title' => 'Embroidery', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'FullColour', 'title' => 'All Full Colour', 'topMenu' => 0, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'SiliconeDigital', 'title' => 'Silicone Digital Print', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'ColourflexTransfer', 'title' => 'Colourflex Transfer', 'topMenu' => 1, 'selectOption' => 1
			),
			array(
				'imgUrl' => 'Debossing', 'title' => 'Debossing XL', 'topMenu' => 0, 'selectOption' => 0
			),
			array(
				'imgUrl' => 'Debossing', 'title' => 'Thermo Debossing XL', 'topMenu' => 0, 'selectOption' => 0
			),
			array(
				'imgUrl' => 'Debossing', 'title' => 'Thermo Debossing', 'topMenu' => 0, 'selectOption' => 0
			),

			
			 
		);

		return $brandingArray;
	}

	function getCatSubMenu(){
		$query = $this->db->query("SELECT * FROM categoriesCurrent WHERE CategoryNum LIKE '%-0' AND CategoryNum NOT LIKE '1__-%' AND CategoryNum NOT LIKE '2__-%' ORDER BY CategoryOrder");
		$arrsFin = array();
		foreach($query->result() as $row){
			$arrs[]=  array($row->CategoryNum => $row->CategoryName); 
		}
	 	foreach ($arrs as $row){ 
				foreach($row as $key=>$value){
					$subCatVals = explode("-",$key);
					$subCatValues = $subCatVals[0];
					$query2 = $this->db->query("SELECT * FROM categoriesCurrent WHERE CategoryNum LIKE '".$subCatValues."-%' ORDER BY CategoryName");
					$arrsFin[] = array($value => array ('urlLink' => $key, 'subMenus' => $query2->result()) );
				}
	 	}
		/* echo "<pre>";
		print_r($arrsFin);
		echo "</pre>"; */
		return $arrsFin;
	}

	function getUsername($username){
		$this->db->select('userEmail')->from('userData')->where('userEmail', $username); 
		$q = $this->db->get(); 
		return $q->num_rows();
	}

	function checkLogin($user){
		//$multipleWhere = ['userEmail  =' => $user];
		$query = $this->db
			->select('*')
			->from('userData')
			->join("customerData"," customerData.CustomerNumber = userData.userAcct")
			->where('userEmail', $user)
			->get();
		return $query->result();
	}

	function getUserByID($userID){
		//$multipleWhere = ['userEmail  =' => $user];
		$query = $this->db
			->select('*')
			->from('userData')
			->join("customerData"," customerData.CustomerNumber = userData.userAcct")
			->where('userID', $userID)
			->get();
		return $query->result();
	}



	function getLogcheck(){

		//Declare all variable here
		if (get_cookie("user_cookies") && get_cookie("user_countryAccess")) {
			$userID = $this->getDecrypt(get_cookie("user_cookies"));
			 
			//Testing and debug using customer usersID to override
			if($userID == '3152'){
				//Sample URL - http://localhost/?changeid=3312&country=nzd
					$getTheParam = parse_url($_SERVER['REQUEST_URI']); 
					$change = explode("&", $getTheParam['query']);
					//print_r($change);

					$urlOne = explode("=", $change[0]);
					$urlTwo = explode("=", $change[1]);
 
					if($urlOne[0] == "changeid" && $urlTwo[0] == "country"){ 
						 
						$valid_passwords = array ("tgpuser" => "tgppw");
						$valid_users = array_keys($valid_passwords);

						$user = $_SERVER['PHP_AUTH_USER'];
						$pass = $_SERVER['PHP_AUTH_PW'];

						$validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

							//Restrict the users access
							/* if (!$validated) {
								header('WWW-Authenticate: Basic realm="My Realm"');
								header('HTTP/1.0 401 Unauthorized');
								die ("Not authorized");
							} */
							$expire=time()+ (60 * 3); //given 3 minutes time only
							$encrypt = $this->getEncrypt($urlOne[1]);   
							$cookie= array(
								'name'   => 'user_cookies',
								'value'  => $encrypt,
								'expire' => $expire,
							);
							$this->input->set_cookie($cookie);

							$pricey = $urlTwo[1];
							if($pricey == 'NZD' || $pricey == 'nzd'){
								$currentCountry = $this->checkip_model->processAvail('nz');  
							}
							if($pricey == 'AUD' || $pricey == 'aud'){
								$currentCountry = $this->checkip_model->processAvail('au'); 
							} 
							//Set cookie
							$this->checkip_model->userCountryCookie($currentCountry);

							redirect('/');   
							 
					} 	 
			}
			//Testing and debug using customer usersID to override


			$query = $this->db
				->select('
					CustomerName,
					CustomerNumber,	
					userID, 
					userAcct, 
					userEmail, 
					userSalt, 
					userType, 
					multiCurrency, 
					quoteStyle, 
					freightStyle, 
					apiReq, 
					apiAcc, 
					skinnedWebsites, 
					customSiteUser, 
					markup1, 
					markup2, 
					markup3, 
					markup4, 
					markup5, 
					markup6, 
					setupMarkup,
					quickQuoteComment,
					visualAccess,
					Currency,
					ThemedSiteMax,
					exclusiveRange,
					CustomerOnHold,
					OrderDashboardAccess'
				)
				->from('userData') 
				->join("customerData"," customerData.CustomerNumber = userData.userAcct")  
				->where('userID', $userID) 
				->get();
				//If change distributors ->join("customerData"," customerData.CustomerNumber = 10138")

			$onHold = $query->result();
			//print_r($onHold[0]->CustomerOnHold);
			
			$queryAccounts = $this->db
				->select(' id, secondaryAccountID, secondaryAccountName, secondaryCurrency, primaryAccountID ')
				->from('secondaryUserAccount')   
				->where('userID', $userID) 
				->get();

			if($onHold[0]->CustomerOnHold == "N"){
 

				$resulsArray = array(
					'userDatas' => $query->result(),
					'loggedIn' => 1,
					'secondaryAccounts' => $queryAccounts->result(), 
				);

				//Switch account
				if(get_cookie("switchaccount_cookies") == "yes" && get_cookie("switchaccountid_cookies")){
					 
					$selectedID = get_cookie("switchaccountid_cookies");
					$queryAccountSelected = $this->db
					   ->select('* ')
					   ->from('secondaryUserAccount')   
					   ->where('id', $selectedID) 
					   ->get();

					   
					  $switchResults = $queryAccountSelected->result();

					  /* Get the current original secondary account */

					  $queryAccountOriginal = $this->db
					   ->select('* ')
					   ->from('customerData')   
					   ->where('CustomerNumber', $switchResults[0]->secondaryAccountID) 
					   ->get();
					 
					   $secondaryOriginalAccount =$queryAccountOriginal->result();
					 
					  if($switchResults):

							$userType = $resulsArray['userDatas'][0]->userType;
							$OrderDashboardAccess = $resulsArray['userDatas'][0]->OrderDashboardAccess;

							$resulsArray['userDatas'][0]->Currency =  $switchResults[0]->secondaryCurrency;
							$resulsArray['userDatas'][0]->CustomerName =  $switchResults[0]->secondaryAccountName;
							$resulsArray['userDatas'][0]->CustomerNumber =  $switchResults[0]->secondaryAccountID;
							$resulsArray['userDatas'][0]->markup1 =  $switchResults[0]->markup1;
							$resulsArray['userDatas'][0]->markup2 =  $switchResults[0]->markup2;
							$resulsArray['userDatas'][0]->markup3 =  $switchResults[0]->markup3;
							$resulsArray['userDatas'][0]->markup4 =  $switchResults[0]->markup4;
							$resulsArray['userDatas'][0]->markup5 =  $switchResults[0]->markup5;
							$resulsArray['userDatas'][0]->markup6 =  $switchResults[0]->markup6;
							$resulsArray['userDatas'][0]->setupMarkup =  $switchResults[0]->setupMarkup;
							$resulsArray['userDatas'][0]->quickQuoteComment =  $switchResults[0]->quickQuoteComment;
							$resulsArray['userDatas'][0]->visualAccess = $secondaryOriginalAccount[0]->visualAccess;
							$resulsArray['userDatas'][0]->userType = $userType; 
							$resulsArray['userDatas'][0]->OrderDashboardAccess = $OrderDashboardAccess; 
								
							$resulsArray['secondaryIDActive'] = $selectedID;
							$resulsArray['secondaryUserIDActive'] = $userID;
					  endif;			
					  
				}
				   
			   //Switch account


			}else{
				$resulsArray = array(
					'userDatas' => null,
					'loggedIn' => 0,
					'secondaryAccounts' => null,
					'secondaryIDActive' => null,
					'secondaryUserIDActive' => null
				);
				//$this->session->sess_destroy();  SESSION TURNED OFF
				delete_cookie("switchaccount_cookies"); 
				delete_cookie("switchaccountid_cookies"); 
				delete_cookie("user_cookies"); 
				delete_cookie("user_countryAccess"); 
			 
			}
			
		}else{
			$resulsArray = array(
				'userDatas' => null,
				'loggedIn' => 0,
				'secondaryAccounts' => null,
				'secondaryIDActive' => null,
				'secondaryUserIDActive' => null
			);
		}
	
		return $resulsArray;
	}

	function getCurrencyData(){
		$queryCurrency = $this->db
				->select(' * ')
				->from('currencyData')    
				->get();
		return $queryCurrency->result();
	}

	function getSkinnedLogcheck($CustomerNumber, $themeID){ 
		$results = array();
		$results['skinnedUserData'] = null;
		$results['skinnedLoggedIn'] = 0;  
		if (get_cookie("skinnedUser_cookies")) {
			$skinnedUserID = $this->getDecrypt(get_cookie("skinnedUser_cookies")); 
			if($skinnedUserID){
				$data = array(
					'skinnedUserID' => $skinnedUserID,
					'skinnedCustomerNumber' => $CustomerNumber,
					'customsiteID' => $themeID,
				);
				$query = $this->db
				->select('
					skinnedUserID,
					customsiteID,	
					skinnedCustomerNumber, 
					skinnedUserEmail, 
					skinnedUserCompany, 
					skinnedUserName' 
				)
				->from('skinnedUserData')  
				->where($data)
				->get();

				if ($query->num_rows() > 0) { 
					$results['skinnedUserData'] = $query->result();  
					$results['skinnedLoggedIn'] = 1;  
				} 

			} 
		} 
		 
		return $results;
	}

	function verifySkinnedLogin($data){
		$results = array();
		$hashPassword = md5($data['passWord']);   
		$query = $this->db->query("SELECT * FROM skinnedUserData WHERE customsiteID= '".$data['themeID']."' AND skinnedUserEmail= '".$data['userName']."' AND skinnedUserPassword = '".$hashPassword."' ");
		
		if ($query->num_rows() > 0) { 
			$results['skinnedLoginData'] = $query->result();       
			$results['skinnedLoginStatus'] = 1; 
			
		}else{
			$results['skinnedLoginData'] = 0;
			$results['skinnedLoginStatus'] = 0;    
		} 
		return $results;
	}

	function verifyForgotPassword($data){
		 $results = array();
		 $query = $this->db->query("SELECT * FROM skinnedUserData WHERE customsiteID= '".$data['themeID']."' AND skinnedUserEmail= '".$data['userNameEmail']."' AND skinnedCustomerNumber = '".$data['customerNumber']."' ");
		 if ($query->num_rows() > 0) { 
			$getUser = $query->result();
			// print_r($getUser);
			$userID = $getUser[0]->skinnedUserID;
			$email = $getUser[0]->skinnedUserEmail;
			$name = $getUser[0]->skinnedUserName;

			$dataUser = array(
                'id' => $userID,  
                'skinEmail' => $email, 
				'skinnedName' => $name, 
				'option' => 2, 
			);  
			$baseUrlDomain =base_url();
 
			$reset =  $this->skinneduser_model->updateResetPw($dataUser);
			$getDetailsEmail =  $this->skinneduser_model->getResetPW($dataUser,  $baseUrlDomain);

			$results['skinnedForgotStatus'] = 1; 
		 }else{
			$results['skinnedForgotStatus'] = 0;    
		 }

		 return $results['skinnedForgotStatus'];
	}

	 
	/* Theme Control */
	function checkID($id){


		//Category only
		if(is_array($id)){
			if(!empty($id)){ 
				//print_r($id);
				if($id[0] == 'all'){ 
					$this->category = 'all';
				} 
			}
		}		
		//Category only

	  	if(is_array($id)){
			if(!empty($id)){  
				if($id[0] == 'all'){ 
					$count = count($id);
					if($count > 1){
						$id = $id[1];
					}else{
						$id = "";
					}
					
				}else{
					$id = $id[0]; 
				} 
			}else{
				$id[0] = 0;
				$id = $id[0];
				//echo "2";
			}
	   	}else{
			if($id == 'index'){
				$id = FALSE;
				//echo "3";
			}else{
				if(isset($id)){
					$id = $id;
					//echo "4";
				}else{
					$id = "";
					//echo "5";
				}
			} 
	   	} 
		if($id){
		 
				$customID = "/".$id;  
				if(strpos($customID , 'ID') !== false){
					$idSafe = strip_tags(stripslashes(substr($customID,8)));
					$idSafeComp = strip_tags(stripslashes(substr($customID,3,5)));
				}else{
					$customID = null;
					$idSafe = null;
					$idSafeComp = null;
					$resultsTemp = null;
					$customHome = "/"; 
				}
				
		}else{
			$customID = null;
			$idSafe = null;
			$idSafeComp = null;
			$resultsTemp = null;
			$customHome = "/"; 
		}

		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "trends.nz" || $_SERVER['SERVER_NAME'] == "www.trends.nz"  || $_SERVER['SERVER_NAME'] == "trends.com.au" || $_SERVER['SERVER_NAME'] == "www.trends.com.au" || $_SERVER['SERVER_NAME'] == "trends.sg" || $_SERVER['SERVER_NAME'] == "www.trends.sg" || $_SERVER['SERVER_NAME'] == "pens.nz" || $_SERVER['SERVER_NAME'] == "www.pens.nz") {
			$this->domainCheck = $this->domainCheck;
		} else { 
			$this->domainCheck = 1; 
		}
		 
	 
		if($customID != null || $this->domainCheck == 1){
			if($this->domainCheck == 1) {
				$custDomainName = $_SERVER['SERVER_NAME']; 
				$custDomainNameWWW = 'www.' .$custDomainName;  
				$query = $this->db
					->select('*')
					->from('customSite') 
					//->like('Domain', $custDomainName)
					//->or_like('Domain', $custDomainNameWWW) 
					->where("Domain = '".$custDomainName."' OR Domain = '".$custDomainNameWWW."'   " )
					->get();
					$resultsTemp = $query->result();
				$customID = NULL;

				
				
				$this->domainCheck = 1; 
				$themeIDskinned= "ID".$resultsTemp[0]->CustomerNumber.$resultsTemp[0]->themeID;
				

				$query2 = $this->db->query("SELECT * FROM customerData WHERE CustomerNumber LIKE '".$resultsTemp[0]->CustomerNumber."' ");
				$customerAccount = $query2->result();

				//Redirect this domain if in array
				$this->redirectThisDomain($resultsTemp[0]->Domain);
				

			} else {  
				$query = $this->db
					->select('*')
					->from('customSite') 
					->like('themeID', $idSafe)
					->like('CustomerNumber', $idSafeComp)
					->get();
					$resultsTemp = $query->result();

					$query2 = $this->db->query("SELECT * FROM customerData WHERE CustomerNumber LIKE '".$resultsTemp[0]->CustomerNumber."' ");
					$customerAccount = $query2->result();

					$this->domainCheck = 0; 
					$themeIDskinned= "ID".$resultsTemp[0]->CustomerNumber.$resultsTemp[0]->themeID; 

					
					
			}
			//If not live then redirect
			if($resultsTemp[0]->Live == 0){
				redirect('/');
			}
			 
		}
		//Only applies on the homepage
		//echo $this->uri->segment(1, 0);
		if($customID != null){ 
				$customHome = '/home'.$customID; 
		} 
		//Only applies on the homepage

		
		$results = array('customerAccount'=>$customerAccount, 'themeArray'=> $resultsTemp, 'customID'=> $customID, 'customHome' => $customHome, 'category'=> $this->category, 'themeDomain'=> $this->domainCheck, 'themeIDskinned'=> $themeIDskinned);
		 
		return $results;
	}

	public function redirectThisDomain($domain){
		// echo $domain. "  "; 
		$serverPath = $_SERVER['DOCUMENT_ROOT']; 
		$json = file_get_contents($serverPath.'/redirectUrl.json');  
		$json_redirectUrl = json_decode($json,true); 
		//echo "<pre>";  print_r($json_redirectUrl); echo "</pre>"; 
		for($x = 0; $x <= count($json_redirectUrl); $x++){ 
			if($json_redirectUrl[$x]['url'] == $domain){
				$https = '//'.$json_redirectUrl[$x]['forward'];
				redirect($https); 
			} 
		}
	  
	}

	function checkItem($item){
		if(isset($item)){
			$item = $item;
		}else{
			$item = "";
		}
		return $item;
	}

	function getEncrypt($text) { 
		return trim($this->encrypt->encode($text)); 
	} 

	function getDecrypt($text) { 
		return trim($this->encrypt->decode($text));
	} 

	function getFilesize($opts){
		if($opts == 1){
			$file_path = './Images/Products.zip';
		}
		if($opts == 2){
			$file_path = './Images/New-Products.zip';
		}
		if($opts == 3){
			$file_path = './Images/ProductsLarge.zip';
		}
		if($opts == 4){
			$file_path = './Images/New-ProductsLarge.zip';
		}
		
    	return   $this->formatSizeUnits(filesize($file_path));
	}
	 
	function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

	function getServerHost(){
		$authKey = "0";
		$specialEmail = "info@trends.nz";
		$domainLocation = "NZ";
		$emailExtension = ".co.nz";
		$authKey = "";

		if(substr($_SERVER['HTTP_HOST'],-22) == "trends.nz" ){
			$domainLocation = "NZ";
			$emailExtension = ".co.nz";
			$authKey = "8ae7e6c0-1346-4992-9955-6c8a24f15d28";
		}
		if(substr($_SERVER['HTTP_HOST'],-19) == "trends.nz" ){
			$domainLocation = "NZ";
			$emailExtension = ".co.nz";
			$authKey = "8ae7e6c0-1346-4992-9955-6c8a24f15d28";
		}
		if(substr($_SERVER['HTTP_HOST'],-20) == "trends.com" ){
			$domainLocation = "NZ";
			$emailExtension = ".co.nz";
			$authKey = "c0eed2bc-7a88-4ef1-89d0-d48d2f40e065";
		}
		if(substr($_SERVER['HTTP_HOST'],-23) == "trends.com.au" ){
			$domainLocation = "AU";
			$emailExtension = ".com.au";
			$specialEmail = "info@trends.com.au";
			$authKey = "bb6ab905-f7f5-4d78-ae28-4824c68f0fce";
		}
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost") {
			$authKey = "0";
			$specialEmail = $specialEmail;
			$domainLocation = $domainLocation;
			$emailExtension = $emailExtension;
			$authKey = "85ac08a7-7b94-49c2-b176-aca01d238eb5";
		}

		return array('domainLocation'=>$domainLocation, 'emailExtension'=>$emailExtension, 'authKey'=>$authKey, 'specialEmail'=>$specialEmail  );
		
	}
	function hide_email($email){
		$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
		$key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999);
		for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])];
		$script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";';
		$script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));';
		$script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"';
		$script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; 
		$script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>';
		return '<span id="'.$id.'">[javascript protected email address]</span>'.$script;
	}



	function checkVisualsUserRequest($userID){
		$query = $this->db->query("SELECT * FROM visualsRequests WHERE userID=".$userID." AND submitted=0");
		return $query->result();
	}

	function checkVisualsFiles($userID){
		$json_data=array();
        $i = 1;
        chdir("VisualsFiles/".$userID); 
        foreach(glob("*.{gif,png,jpg,jpeg,pdf,ai,cdr,zip,rar,7z,eps,GIF,PNG,JPG,JPEG,PDF,AI,CDR,ZIP,RAR,7Z,EPS}", GLOB_BRACE) as $file) {
           
           $json_array['visualFiles']=$file; 
           array_push($json_data,$json_array); 
           $i++;
        }  
        return  $json_data;  
	}

	function deleteArtworkFile($userID, $visualFiles){
		//echo $userID. "/ " .$visualFiles;
		unlink($_SERVER['DOCUMENT_ROOT']."/VisualsFiles/".$userID."/".$visualFiles);
		$results = 1;
		return $results;
	}

	function updateProjectDetails($userID, $projectName, $instructions){
		$dataValues = array( 
			'projectName' => $projectName,
			'instructions'=> $instructions

		);
		$this->db->where('userID', $userID);
		$this->db->where('submitted', 0);
		$results = $this->db->update('visualsRequests', $dataValues); 
        return $results;  
	}

	function uploadArtworkFile($userID, $file){
		 if($file['error'] === UPLOAD_ERR_OK) {
			$error = false;

			$serverPath = $_SERVER['DOCUMENT_ROOT']; 
			$pathVisualUrl = $serverPath.'/VisualsFiles/'; 
			
			$filenameTemp = $file['tmp_name'];
			$filename = $file['name'];
 
			if (!file_exists($pathVisualUrl.$userID)) {
				mkdir($pathVisualUrl.$userID, 0777, true);
			} 
			$uploaddir = $pathVisualUrl.$userID;
			
			move_uploaded_file($filenameTemp, $uploaddir."/".$filename); 

			$results = 1;

			return $results;
		} 

		 
	}

	function getProductsVisualList(){
		$query = $this->db->query("SELECT Prim, Code, Colours, Name, visualsAvailable, Active, PrintType1, PrintType2, PrintType3, PrintType4, PrintType5, PrintType6, PrintType7, PrintType8, PrintType9, PrintType10, PrintDescription1, PrintDescription2, PrintDescription3, PrintDescription4, PrintDescription5, PrintDescription6, PrintDescription7, PrintDescription8, PrintDescription9, PrintDescription10  FROM productsCurrent WHERE Active = '1' AND visualsAvailable = '1' ORDER BY Name");
		$results = $query->result();
		
			$visCount = count($results)-1; 
			 
			for($x = 0; $x <= $visCount; $x++){ 
				$results[$x]->Name =  $this->cleanString($results[$x]->Name);
			}  
			
		return $results;
	}

	function getTheItemColours($itemCode){
		$query = $this->db->query("SELECT * FROM productsCurrent WHERE Code = '".$itemCode."' ");
		$results =  $query->result();

		//Get the Branding Options new
		 
		$queryConverted = $this->db->query("SELECT brandingMethod, brandingArea FROM  additionalOptions WHERE    ProductCode = ".$itemCode."   ORDER BY orderRow  ASC ");
		$resultsAddtionalOptions = $queryConverted->result();
		$rowsConverted = $queryConverted->num_rows(); 
 
		if($rowsConverted > 0 ){  

			 //Make blank frist
			 for($p = 1; $p <= 10; $p++){ 
				$pInc = "PrintType".$p;
				$results[0]->$pInc = "";

				$pInc2 = "PrintDescription".$p;
				$results[0]->$pInc2 = "";

			}

			$resultsConvertedCount = count($resultsAddtionalOptions);

			//Insert the branding new
			$arrayBrandingCollection1 = [];
			$arrayBrandingCollection2 = [];
			for($rc = 0; $rc < $rowsConverted; $rc++){
				$rcInc = $rc + 1; 
				$pInc = "PrintType".$rcInc;
				$pInc2 = "PrintDescription".$rcInc; 

				if($resultsAddtionalOptions[$rc]->brandingMethod){
					$strSeparate = explode ("|", $resultsAddtionalOptions[$rc]->brandingArea); 
					//$results[0]->NewBrandingTEST[$rc] = $strSeparate;
					if(count($strSeparate) > 1){ 
						for($sep = 0; $sep < count($strSeparate); $sep++){
							//$period = $this->checkifPeriod($strSeparate[$sep]);
							$period = ".";  
							if (strpos($strSeparate[$sep], ".")  !== false) {
								$period = "";
							} 
							$arrayBrandingCollection1[$rc][$sep]  =  $resultsAddtionalOptions[$rc]->brandingMethod. " - ".$this->cleanString(trim($strSeparate[$sep])).$period; 
						}  
						
					}else{
						$arrayBrandingCollection2[$rc]  =  $resultsAddtionalOptions[$rc]->brandingMethod. " - ".$this->cleanString($resultsAddtionalOptions[$rc]->brandingArea);  	 

					}  
				} 

		   }

		   $arrayNewBrandingFinalCollection = [];
		   if(count($arrayBrandingCollection1) > 0){ 
				 foreach($arrayBrandingCollection1 as $row1){ 
					 for($xx = 0; $xx < count($row1); $xx++){
						$arrayNewBrandingFinalCollection[] = $row1[$xx];
					 }
					
				 }
		   }
		   if(count($arrayBrandingCollection2) > 0){
				foreach($arrayBrandingCollection2 as $row2){ 
					$arrayNewBrandingFinalCollection[] = $row2;
				}
	   		}
		  
		   $results[0]->FinalBranding = $arrayNewBrandingFinalCollection;
		   



		}

		return $results;
	}

	function saveToVisuals($data){ 
		$query = $this->db->query("SELECT  Name FROM productsCurrent WHERE  Code = '".$data['productItem']."' ");
		$itemName = $query->result();
		$itemName = $itemName[0]->Name;
		$results = 0;
		if($itemName){ 

			//  echo "Here " .$data['ItemInstructions']; 
			$dataItemInstructions =  $data['ItemInstructions']; 
			$datas = array(
				'userID' => $data['userID'],
				'projectName' => $this->cleanString($data['projectName']), 
				'itemCode'=> $data['productItem'],
				'itemName'=> $itemName,
				'itemCols'=> $this->cleanString($data['ItemColour']),
				'printOpt'=> $this->cleanString($data['BrandingOption']),
				'printPos'=> $this->cleanString($data['BrandingPosition']),
				'printCols'=> $this->cleanString($data['PrintColours']),
				'instructions'=> $this->cleanString($data['instructions']),
				'instructionsItem'=> $this->cleanString($dataItemInstructions),
				'visualType'=> $data['VisualType'] 
				
			);
			 
			$this->db->insert('visualsRequests', $datas); 
			$results = 1;
		}

		return $results; 

	}

	function deleteItemVisuals($uid){
			$data = array(
				'uid' => $uid 
			);
			$deleted = $this->db->delete('visualsRequests', $data); 
			$results = 1;
			return $results;  
	}
	function updateVisualItems($uid, $cols, $details){
		$dataValues = array( 
			$cols => $details  
		);
		$this->db->where('uid', $uid); 
		$this->db->update('visualsRequests', $dataValues); 
		$results = 1;
        return $results;  
	}

	function sendEmailToVisuals($userID, $visualForm){

		$query = $this->db->query(" SELECT a.userID, a.projectName, a.instructions, b.userAcct, b.userEmail FROM visualsRequests a, userData b WHERE a.userID=b.userID AND a.userID=".$userID." AND a.submitted=0 ORDER BY a.uid LIMIT 1 ");
		$results = $query->result();


		if($results){
			$dataRows = array();
			foreach($results as $row){
				$dataRows['userID'] = $row->userID;
				$dataRows['projectName'] = $row->projectName;
				$dataRows['instructions'] = $row->instructions;
				$dataRows['userAcct'] = $row->userAcct;
				$dataRows['userEmail'] = $row->userEmail;
			} 
			
			$query2 =  $this->db->query("SELECT CustomerName, CSR, visualAccess  FROM customerData WHERE CustomerNumber='".$visualForm->CustomerNumber."' ");
			$resultCust = $query2->result();
			foreach($resultCust as $row){
				$dataRows['customerName'] = $row->CustomerName;
				$dataRows['csrEmail'] = $row->CSR;
				$dataRows['visualAccess'] = $row->visualAccess;
			}
			
			//PHP Mailer
			$mail = new PHPMailer;
			//print_r($mail);
			//print_r($dataRows);
				
			//echo "Ettto ".$dataRows['projectName'];

			 

		 	$mail->isSMTP();
			$mail->Host = 'smtp.sitehost.co.nz';
			$mail->SMTPAuth = false;
			//$mail->Username = 'visuals@trendscollection.co.nz';
			//$mail->Password = 'yq609792';
			$mail->Port = 25;

			$mail->setFrom('visuals@trends.nz', 'TRENDS Visualisation Request');
			$mail->addAddress('jeoffyh@tuapeka.co.nz');
			//$mail->addAddress('sarahr@tuapeka.co.nz');
			$mail->addAddress('visuals@tuapeka.co.nz');
			$mail->addAddress($dataRows['csrEmail']);

			chdir("VisualsFiles/".$userID);
			foreach(glob("*.{gif,png,jpg,jpeg,pdf,ai,cdr,zip,rar,7z,eps,GIF,PNG,JPG,JPEG,PDF,AI,CDR,ZIP,RAR,7Z,EPS}", GLOB_BRACE) as $file) {
				$mail->addAttachment($file);
			}
			
			$mail->isHTML(true);
			$mail->Subject = "Visual - ".$dataRows['customerName']." - ".$dataRows['projectName']; 
			 
			if(!is_null($dataRows['instructions'])) {
				$bodyofemail = "<b>Instructions:</b> ".$dataRows['instructions']."<br />";
			} else {
				$bodyofemail = "";
			}
			$bodyofemail.= "<b>Customer:</b> ".$dataRows['customerName']."<br />";
			$bodyofemail.= "<b>Customer Email:</b> ".$dataRows['userEmail']."<br />";
			$bodyofemail.= "<b>CSR Email:</b> ".$dataRows['csrEmail']."<br />";  

			$query3 =  $this->db->query(" SELECT * FROM visualsRequests WHERE userID=".$userID." AND submitted=0 ORDER BY uid ");
			$resultInfo = $query3->result();

			$visualTypeGet = "";
			$TwoD = "2D Visual";
			if($dataRows['visualAccess'] == 0){
				$visualTypeGet = $TwoD;
			}else{ 
					$visualTypeGet = $visualForm->VisualType; 

			}

			
			
			$bodyofemail.= "<b><span style='color:#fff; background-color:#00B0B9'> Visualization Type: ".$visualTypeGet."</span></b><br /><br />";
 
		 
			foreach($resultInfo as $rowInfo){
				
				
				$bodyofemail.= "<span style='font-size:1.5em'>".$rowInfo->itemCode." - ".$rowInfo->itemName."</span><br />";
				$bodyofemail.= "<b>Product Colour:</b> ".$rowInfo->itemCols."<br />";
				$bodyofemail.= "<b>Branding Option:</b> ".$rowInfo->printOpt."<br />";
				//$bodyofemail.= "<b>Position:</b> ".$rowInfo->printPos."<br />";
				$bodyofemail.= "<b>Colour:</b> ".$rowInfo->printCols."<br />";
				$bodyofemail.= "<b>Other Instructions:</b> ".$rowInfo->instructionsItem."<br /><br />";
			}
		 

			$mail->Body    = $bodyofemail;

			 

			/*if(!$mail->send()){

					//Second option
				//If email above will fail!

				$this->email->from('visuals@trends.nz', 'TRENDS Visualisation Request');
				$this->email->to('visuals@tuapeka.co.nz'); 
				$list = array('jeoffyh@tuapeka.co.nz', $dataRows['csrEmail']);
				$this->email->cc($list);
				
				$subject = "Visual - ".$dataRows['customerName']." - ".$dataRows['projectName']; 
				$this->email->subject($subject);

				chdir("VisualsFiles/".$userID);
				foreach(glob("*.{gif,png,jpg,jpeg,pdf,ai,cdr,zip,rar,7z,eps,GIF,PNG,JPG,JPEG,PDF,AI,CDR,ZIP,RAR,7Z,EPS}", GLOB_BRACE) as $file) {
					$this->email->attach($file);
				} 

				$this->email->message($bodyofemail);
				$this->email->set_mailtype("html");

				
				if($this->email->send()){
					$results = 1;
				}else{
					$results = 0;
				}

				
			}else{
				$results = 1;
			} */

			if(!$mail->send()) {
				
				echo 'Mailer Error: ' . $mail->ErrorInfo; 
				 $results = 0;

				 
			} else {
			 
				$dataValues = array( 
					'submitted' => 1  
				);
				$this->db->set('date', 'NOW()', FALSE);
				$this->db->where('userID', $userID); 
				$this->db->where('submitted', 0); 
				$updated = $this->db->update('visualsRequests', $dataValues); 

				foreach(glob("*.{gif,png,jpg,jpeg,pdf,ai,cdr,zip,rar,7z,eps,GIF,PNG,JPG,JPEG,PDF,AI,CDR,ZIP,RAR,7Z,EPS}", GLOB_BRACE) as $file) {
					unlink($_SERVER['DOCUMENT_ROOT']."/VisualsFiles/".$userID."/".$file);
				}

				$results = 1; 
			}  


 
		}else{  
			
			$results = 0;
		} 
		
		return $results;
	}


	function updateUserPW($data){
		 
		$results = 0;
		$newSalt = $this->grind_salt();
		$newHash = hash('sha256',$data['pw1'].$newSalt);

		$dataValues = array( 
			'userHash' => $newHash,
			'pwReset' => null,
			'userSalt'=> $newSalt
		);
		 
		$this->db->where('userID', $data['userID']);  
		$updated = $this->db->update('userData', $dataValues); 
		if($updated){
			$results = 1;
		}
		return $results;  
	}

	function grind_salt() {
		mt_srand(microtime(true)*100000 + memory_get_usage(true));
		return md5(uniqid(mt_rand(), true));
	}

	function random(){
		return  date("Ymd");
	}

	function randomFast(){
		return  rand();
	}

	function cutTitle($in){
		return  strlen($in) > 23 ? substr($in,0,23)."..." : $in;
	}

	function shortTitle($in){
		return  strlen($in) > 20 ? substr($in,0,20)."..." : $in;
	}

	function captionTitle($in){
		return  strlen($in) > 15 ? substr($in,0,15)."..." : $in;
	}


	function getAvailableProductAccess($siteLogcheck, $checkAvailCountry, $customArray){
		//print_r($checkAvailCountry);
		$availQuery = " ";
		if($siteLogcheck['userDatas'][0]->Currency != ""  && $siteLogcheck['loggedIn'] == 1 && count($customArray['customerAccount']) == 0 ) {
			$currencySort = $siteLogcheck['userDatas'][0]->Currency;	
			
			if($currencySort == "NZD"){
				$availQuery = "  availNZ = '1' AND ";
			}
			if($currencySort == "AUD"){
				$availQuery = "  availAU  = '1' AND ";
			}
			if($currencySort == "SGD"){
				$availQuery = "  availSG  = '1' AND ";
			}
			if($currencySort == "MYR"){
				$availQuery = "  availMY  = '1' AND ";
			}

			if($siteLogcheck['userDatas'][0]->multiCurrency == 1){
				//$availQuery = "  ";
			}
			
		} else {
			if($checkAvailCountry == "availNZ") {	
				$currencySort = "NZD";
			} 
			if($checkAvailCountry == "availAU") {
				$currencySort = "AUD";
			} 
			if($checkAvailCountry == "availSG") {
				$currencySort = "SGD";
			} 
			if($checkAvailCountry == "availMY") {
				$currencySort = "MYR";
			}

			if($currencySort == "NZD"){
				$availQuery = "  availNZ = '1' AND ";
			}
			if($currencySort == "AUD"){
				$availQuery = "  availAU  = '1' AND ";
			}
			if($currencySort == "SGD"){
				$availQuery = "  availSG  = '1' AND ";
			}
			if($currencySort == "MYR"){
				$availQuery = "  availMY  = '1' AND ";
			}
		}
		 
		return array('availQuery'=>$availQuery, 'currencyAvailable' => $currencySort);
	}

	public function getTheMainAccount($secondaryAccounts){
		//get the first in array
		//$secondaryAccounts[0];
		$results = null;
		if($secondaryAccounts){
			$primaryAccountID = $secondaryAccounts[0]->primaryAccountID;
			$getAccount = $this->getCustomerDataByAccount($primaryAccountID);
			$results = $getAccount[0]->CustomerName. " - " .$getAccount[0]->Currency;
		}
		return $results;
	}

	public function getCustomerDataByAccount($accountNum){
		$query  = $this->db->query("SELECT * FROM customerData WHERE CustomerNumber = ".$accountNum." ");
		$customerAccount = $query->result();
		return $customerAccount;
	}
 


	function getRecentlyViewed($userID){
				$getThis = 'myitem-'.$userID.'-'; 
				$i = 1; 
					
				$prodsTable = $tableItems;   
				foreach($this->input->cookie() as $codeRow){ 
				 
						if (strpos($codeRow, $getThis) !== false){ 
							$countL = strlen($userID) + 7 + 1;
							$singleCode = substr($codeRow, $countL);  
							 
							$query = $this->db->query(" SELECT Name FROM productsCurrent WHERE Code = '".$singleCode."' ");
							if ($query->num_rows() > 0) { 
								$getMe = $query->result();
								$thisName = '';
								foreach ($getMe as $row){
										$thisName.= $row->Name;  
								}
								$arrFin[] = $singleCode.','.$thisName; 
							} 	
						
						}  
						$i++;
				}    
				 
				if($arrFin){
					//SESSION TURNED OFF
					$this->session->storeViewed = $arrFin;
					$results = $this->session->storeViewed; 
				}else{
					$results = 1;
				}
				

				return $results;
	}

	public function DimensionCleaner($string, $cut = null){
		 
		$res = $string;
 
		$specChars = array(
			 'â€“'=>'-' 
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		}
		//$res = preg_replace("/[^A-Za-z0-9\-]/", " ", $res); 
		if($cut){ 
			 $res = $this->cutTitle($res);  
		}
		
		return $res;
	}

	public function cleanString($string, $cut = null){
		//$cut = $cut || null;
		//$res = str_replace(" â€“ ", " - ", $string);
		//$res = preg_replace("/[^A-Za-z0-9\-]/", " ", $string); 
		$res = $string;
 
		$specChars = array(
			'!' => '',    
			'$' => '', '&amp;' => '',    '\'' => '',   
			 '*' => '',   '₹' => '',     
			'/-' => '',    ':' => '',    ';' => '',
			'<' => '',    '=' => '',    '>' => '',
			'?' => '',    '@' => '',    '[' => '',
			'\\' => '',   ']' => '',    '^' => '',
			'_' => '',    '`' => '',    '{' => '',
			'|' => '',    '}' => '',    '~' => '',
			'-----' => '-',    '----' => '-',    '---' => '-',
			'--' => '-',   '/_' => '-',  '&039'=> '', '&#039'=> '', '&#039;'=> '’',
			'&039;'=>'', 'â€”' => '-', 'â€™'=>'’', 'â€“'=>'-', 'â€˜'=>'’',
			'â€¢' => '', 'Â'=> '', '&nbsp;'=>'', '&nbsp'=>'', "Ã¢â‚¬â„¢s"=> "", "Ã¢â‚¬â„¢"=>'',
			"Ã¢â‚¬Ëœ"=>'', "Ã‚Â®"=> "®", "â„¢" => "™", '&quot;'=> '"',   'quot;'=> '"'
			
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		}
		//$res = preg_replace("/[^A-Za-z0-9\-]/", " ", $res); 
		if($cut){ 
			 $res = $this->cutTitle($res);  
		}
		
		return $res;
	}

	public function cleanStringAPPA($string){
		 
		$res = $string;
 
		$specChars = array(
			'!' => '',    '"' => '',
			'#' => '',    '$' => '',     
			'&amp;' => '',    '\'' => '',   
			 '*' => '',    '+' => '',
			 '₹' => '',     
			'/-' => '',    ':' => '',    ';' => '',
			'<' => '',    '=' => '',    '>' => '',
			'?' => '',    '@' => '',    '[' => '',
			'\\' => '',   ']' => '',    '^' => '',
			'_' => '',    '`' => '',    '{' => '',
			'|' => '',    '}' => '',    '~' => '',
			'-----' => '-',    '----' => '-',    '---' => '-',
			'--' => '-',   '/_' => '-',  '&039'=> '', '&#039'=> '', '&#039;'=> '’',
			'&039;'=>'', 'â€”' => '-', 'â€™'=>'',  'â€˜'=>'’', 'Ã'=>'', '¢'=>'', 'â'=>'', '¬'=> '',
			'â€¢' => '', 'Â'=> '', '&nbsp;'=>'', '&nbsp'=>'', 'Ã¢â‚¬â„¢s'=> '', 'Ã¢â‚¬â„¢'=>'',
			'Ã¢â‚¬Ëœ'=>'', 'Ã‚Â®'=> "", ' â€™ '=> '', ' â€™'=> '', 'Ã¢â‚¬â€œ'=> '', 'Ã¢â‚'=> '', '¬â€œ'=> '',
			'Ã‚Â® '=> "", 'Ã‚Â®'=>'', 'â€“'=>'' 
			
			
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		} 
		 
		return $res;
	}

	public function cleanSearchTop($string, $cut = null){
		 
		$res = $string;
 
		$specChars = array(
			'&amp;' => '&', 'Â' => '', 'â€“'=>''
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		} 
		if($cut){ 
			 $res = $this->cutTitle($res);  
		}
		
		return $res;
	}

	public function cleanURLs($string, $cut = null){
		 
		$res = $string;
 
		$specChars = array(
			'!' => '',    '"' => '', "'"=> '',
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
			'-----' => '',    '----' => '',    '---' => '',
			'/' => '',    '--' => '',   '/_' => '',  '&039'=> '',
			'&039;'=>'', 'â€”' => '-' 
			
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		}
		//$res = preg_replace("/[^A-Za-z0-9\-]/", " ", $res); 
		if($cut){ 
			 $res = $this->cutTitle($res);  
		}
		
		return $res;
	}

	public function cleanAbout($string, $cut = null){
		 
		$res = $string;
 
		$specChars = array(
			'â€“' => '', 'â€™'=> '', 'Ã¨' => '', 'Ã‰'=> '', 'â€¦' => '', 'Ã›'=> '' 
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		}
		//$res = preg_replace("/[^A-Za-z0-9\-]/", " ", $res); 
		if($cut){ 
			 $res = $this->cutTitle($res);  
		}
		
		return $res;
	}

	public function cleanCustomers($string, $cut = null){
		 
		$res = $string;
 
		$specChars = array(
			 " - "=> "-", "�" =>"", " – " => "-", "'"=> "", '"'=> "", '&amp;' => '&', '&amp;'=> '&',
			 'â€“' => '', 'â€™'=> '', 'Ã¨' => '', 'Ã‰'=> '', 'â€¦' => '', 'Ã›'=> '',
			 "'"=>"",  "Â" => "", "â"=> "", "–"=> "", "Ã"=>"", "Ã"=>"","Ã "=> "" 
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		} 
		if($cut){ 
			 $res = $this->cutTitle($res);  
		}
		
		return $res;
	}

	
	public function cleanExcel($string, $cut = null){
		 
		$res = $string;
 
		$specChars = array(
			'&amp;'=> '&',  '&amp;'=> '&', 
			 '&#039;'=> '’',
			'&#194;'=> '', '&#174;'=>'®', '&amp' => '&', '&;'=> '&'
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		} 
		if($cut){ 
			 $res = $this->cutTitle($res);  
		}
		
		return $res;
	}

	public function cleanStrExcel($value){
		$value = str_replace('Â', '', $value);
		$value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
		return $value;
	}


	public function HtmlAllEntities($str){
		$res = '';
		$strlen = strlen($str);
		for($i=0; $i<$strlen; $i++){
		  $byte = ord($str[$i]);
		  if($byte < 128) // 1-byte char
			$res .= $str[$i];
		  elseif($byte < 192); // invalid utf8
		  elseif($byte < 224) // 2-byte char
			$res .= '&#'.((63&$byte)*64 + (63&ord($str[++$i]))).';';
		  elseif($byte < 240) // 3-byte char
			$res .= '&#'.((15&$byte)*4096 + (63&ord($str[++$i]))*64 + (63&ord($str[++$i]))).';';
		  elseif($byte < 248) // 4-byte char
			$res .= '&#'.((15&$byte)*262144 + (63&ord($str[++$i]))*4096 + (63&ord($str[++$i]))*64 + (63&ord($str[++$i]))).';';
		}
		return $res;
	  }


	public  function convert_to_utf8_recursively($mixed){
		if (is_array($mixed)) {
			foreach ($mixed as $key => $value) {
				$mixed[$key] = utf8ize($value);
			}
		} else if (is_string ($mixed)) {
			$value =  utf8_encode($mixed);

			$res = $this->cleanCustomers($value); 

			return htmlspecialchars($res, ENT_QUOTES, 'UTF-8'); 
			
			
		}
		return $mixed;
  	}

	public function cleanCompliance($string, $cut = null){
		 
		$res = $string;
 
		$specChars = array(
			 "Â®"=> "®"   
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		} 
		if($cut){ 
			 $res = $this->cutTitle($res);  
		}
		
		return $res;
	}


	public function sortByOptions(){
		$data = array(
			'lowfirst' => 'Price: Low to high',
			'highfirst' => 'Price: High to low',
			'atoz' => 'Name: A to Z',
			'ztoa' => 'Name: Z to A',
			'releasednew' => 'Released: Newest to Oldest',
			'releasedold' => 'Released: Oldest to Newest'
		);

		return $data;
	}

	public function pricesRange($num){
		$num = $num || null;
	
		$limit = 30;
		$results = array();
		for($x = 1; $x <= $limit; $x++){
			$results[] = $x;
		}

		return $results;
	}

	public function checkIfAllCategory($item, $customArray){
		
		if($customArray['category'] == "all"){
			$valueN = false;
		}else{
			if($item != "products" ){
				$getVal  = substr($item, 2); 
				if (substr_count ($getVal, '-') > 0)
				{
					$getVal2  = substr($getVal, 1); 
					$getVal = $getVal2;
				}
				if($getVal > 0){
					 redirect('/category/'.$item.'/all'); 
				}  
			}
			
		} 
		return $valueN;
	}

	public function Authorized($authenticate){
		if(this.checkLogin($authenticate) !== null):
			return true;
		else:	
			return http_response_code(401); 
		endif;
	}

	public function UnAuthorized(){
		return http_response_code(401); 
	}
	
	public function CMSUserEncrpytCookie($userID){
		$simple_string = $userID;
								
		// Store the cipher method
		$ciphering = "AES-128-CTR";
										
		// Use OpenSSl Encryption method
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;
										
		// Non-NULL Initialization Vector for encryption
		$encryption_iv = '001234567891011121';
										
		// Store the encryption key
		$encryption_key = "CMSforDevs";
										
		// Use openssl_encrypt() function to encrypt the data
		$encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);

		return $encryption;
	}
	 

	public function mobileDetector(){
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		$result = 0;

		//Ipad tablets
		if (preg_match('/tablet|Tablet|tab|pad|ipad|iPad|linux|lenovo/i', $useragent)) 
		{
			$result = 1;
		}
		 //Mobiles
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			$result = 1;
		} 
		return $result;
	}

	
}
