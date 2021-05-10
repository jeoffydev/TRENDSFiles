<?php

 
 
class Checkip_Model extends CI_Model {

	public function __construct(){ 
		parent:: __construct();  
	 
		/* Variables  */
		$this->domainCheck = "0";  
		$this->category = null; 
 
	}

	function availCheckAccess($checkAvailCountry){
	 
		if($checkAvailCountry) {
			$availVariable = $checkAvailCountry; 
			$availAccess = ' AND '.$availVariable.' = 1 ';
		
		} else {
			$availAccess = "";
		} 

		return $availAccess;
	}

	function checkAvailCountry($siteLogcheck, $customArray){
		
		

		 
				$currentCountry = $this->processAvail('nz'); 
				if($siteLogcheck['loggedIn'] == 1 && $siteLogcheck['userDatas'][0]->userID && count($customArray['themeArray']) == 0){ 

					    $userCurrency = $this->siteLogcheck['userDatas'][0]->Currency;

						if($userCurrency == 'NZD'){
							$priceys = 'availNZ';
						}
						if($userCurrency == 'AUD'){
							$priceys = 'availAU';
						}  
						if($userCurrency == 'SGD'){
							$priceys = 'availSG';
						}  
						if($userCurrency == 'MYR'){
							$priceys = 'availMY';
						} 

						if (get_cookie("user_countryAccess")) { 
								//echo "User Yes";
								$currentCountry = get_cookie("user_countryAccess");

								if($priceys !== $currentCountry){ 
									if($userCurrency == 'NZD'){
										$currentCountry = $this->processAvail('nz');  
									}
									if($userCurrency == 'AUD'){
										$currentCountry = $this->processAvail('au'); 
									} 
									if($userCurrency == 'SGD'){
										$currentCountry = $this->processAvail('sg'); 
									} 
									if($userCurrency == 'MYR'){
										$currentCountry = $this->processAvail('my'); 
									} 
								}
						}else{
								//echo "User No";
								if($this->siteLogcheck['userDatas'][0]->Currency == 'NZD'){
									$currentCountry = $this->processAvail('nz');  
								}
								if($pricey == 'AUD'){
									$currentCountry =  $this->processAvail('au'); 
								}  
								if($pricey == 'SGD'){
									$currentCountry =  $this->processAvail('sg'); 
								} 
								if($pricey == 'MYR'){
									$currentCountry =  $this->processAvail('my'); 
								}   
						}

				}else{
					
						if(count($customArray['themeArray']) == 0 && $siteLogcheck['loggedIn'] == 0){
					 
							if (get_cookie("user_countryAccess")) { 
									//echo "Loggedout Yes";
									$currentCountry = get_cookie("user_countryAccess");
								 
									if($currentCountry !== $this->getIPAccess()){
										if($this->getIPAccess() == 'availNZ'){
											$currentCountry = $this->processAvail('nz');  
										}
										if($this->getIPAccess() == 'availAU'){
											$currentCountry = $this->processAvail('au'); 
										}  
										if($this->getIPAccess() == 'availSG'){
											$currentCountry = $this->processAvail('sg');  
										}
										if($this->getIPAccess() == 'availMY'){
											$currentCountry = $this->processAvail('my');  
										}
									}
							}else{
								$currentCountry = $this->getIPAccess();
							} 
						
						}
						
						
						if(count($customArray['themeArray']) > 0){   
								$pricey =  $customArray['customerAccount'][0]->Currency;

								if($pricey == 'NZD'){
									$priceys = 'availNZ';
								}
								if($pricey == 'AUD'){
									$priceys = 'availAU';
								}  
								if($pricey == 'SGD'){
									$priceys = 'availSG';
								}
								if($pricey == 'MYR'){
									$priceys = 'availMY';
								}

								if (get_cookie("user_countryAccess")) { 
										
										$currentCountry = get_cookie("user_countryAccess");
 
										if($priceys !== $currentCountry){ 
											if($pricey == 'NZD'){
												$currentCountry = $this->processAvail('nz');  
											}
											if($pricey == 'AUD'){
												$currentCountry = $this->processAvail('au'); 
											}  
											if($pricey == 'SGD'){
												$currentCountry = $this->processAvail('sg'); 
											}  
											if($pricey == 'MYR'){
												$currentCountry = $this->processAvail('my'); 
											}  
										}
								}else{
										
										//echo "YEEEE";
										if($pricey == 'NZD'){
											$currentCountry = $this->processAvail('nz');  
										}
										if($pricey == 'AUD'){
											$currentCountry = $this->processAvail('au'); 
										} 
										if($pricey == 'SGD'){
											$currentCountry = $this->processAvail('sg'); 
										} 
										if($pricey == 'MYR'){
											$currentCountry = $this->processAvail('my'); 
										} 
								}
						}
				} 

				//Set cookie
				$this->userCountryCookie($currentCountry);

		 

		
			
		return $currentCountry;  
	}

	function getIPAccess(){
		//echo "Loggedout No";
									//$ip = '1.32.191.255';
									$ip = $this->get_client_ip_server();
									
									//My IP 222.154.227.23
									//AU 103.225.69.10 
									//US 40.74.243.24
									//SG 1.32.191.255
									$x = ip2long($ip);
									
									//if ($x === FALSE) die('ERROR: INVALID IP ADDRESS');
									
									if ($x === FALSE){
										$currentCountry = $this->processAvail('nz');  
									}
								
									// IP ADDRESSES ARE UNSIGNED AND MAY RETURN NEGATIVE VALUES
									$ip_number = sprintf('%u', $x);  
									//echo $ip_number;
									
									$query =  $this->db->query(" SELECT  country_code, country_name FROM    ip2country WHERE  $ip_number BETWEEN ip_number_lo AND     ip_number_hi LIMIT 1 ");
									$resultIPCountry = $query->result();
									
									if($resultIPCountry){
										foreach($resultIPCountry as $row){ 
											if($row->country_code == 'NZ'){  
												$currentCountry = $this->processAvail('nz'); 
											} elseif ($row->country_code == 'AU'){ 
												$currentCountry = $this->processAvail('au'); 
											} elseif ($row->country_code == 'SG'){ 
												$currentCountry = $this->processAvail('sg'); 
											} elseif ($row->country_code == 'MY'){ 
												$currentCountry = $this->processAvail('my'); 
											} else{ 
												//$currentCountry = 'unknown';
												$currentCountry = $this->processAvail('nz'); 
											}
										}
									} 
								 return $currentCountry;
	}

	function userCountryCookie($currentCountry){
		$expire=time()+60*60*24*30;
		$cookie= array(
			'name'   => 'user_countryAccess',
			'value'  => $currentCountry,
			'expire' => $expire,
		);
		return $this->input->set_cookie($cookie); 

	}


	function get_client_ip_server() {
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if($_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if($_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if($_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		
		else
			$ipaddress = 'UNKNOWN';
	
		return $ipaddress;
	}
	
	
	function processAvail($country){
		if($country == 'nz'){
			$resultQuery = 'availNZ';
		}
		if($country == 'au'){
			$resultQuery = 'availAU';
		}
		if($country == 'sg'){
			$resultQuery = 'availSG';
		}
		if($country == 'my'){
			$resultQuery = 'availMY';
		}
		return $resultQuery;
	
	}
 
 
}
