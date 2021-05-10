<?php
 
class Recentlyviewed_Model extends CI_Model {

	public function __construct(){ 
		 
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tablePricing = "productsPricingDEV";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChangesDEV";
			$this->productChangeTypes = "productChangeTypes";
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChanges";
			$this->productChangeTypes = "productChangeTypes";
		}


		$this->load->model('productsdisplay_model');
		$this->load->model('general_model');
	}

	function saveCookie($getItem, $siteLogcheck, $customArray){
		
		 
		if(count($customArray['themeArray']) == 0 && $siteLogcheck['loggedIn'] == 1):
				$userID = $siteLogcheck['userDatas'][0]->userID;
				$date_of_expiry = time()+3600*24*30*3;
				$sessionArray = 'viewed-'.uniqid(); 
				if($getItem){
					$valueSession = 'myitem-'.$userID.'-'.$getItem; 
					$cookie= array(
						'name'   => $sessionArray,
						'value'  => $valueSession,
						'expire' => $date_of_expiry,
					);
					return $this->input->set_cookie($cookie);
		
				}

		 
		endif;		

		 
	}

	 
 
	
	 
}
