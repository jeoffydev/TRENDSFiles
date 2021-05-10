<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model');  
		$this->load->model('checkip_model'); 
		$this->load->model('search_model');
		$this->load->model('productsdisplay_model');    
		$this->load->model('resetuser_model');    

			//SiteLog
			$this->siteLogcheck = $this->general_model->getLogcheck();  

		/*Loading Menus */
		$this->productsMenu = $this->general_model->getProductsMenu();  
		$this->collectionsMenu = $this->general_model->getCollectionsMenu();  
		$this->premiumMenu = $this->general_model->getPremiumMenu();  
		$this->worldSourceMenu = $this->general_model->getWorldSourceMenu();
		$this->promoShopMenu = $this->general_model->getPromoShopMenu();
		$this->brandingMenu = $this->general_model->getBrandingMenu();
		$this->getCatSubMenu = $this->general_model->getCatSubMenu();
		/*Loading Menus */

	}



	function _remap($hash) {
        $this->index($hash);
	}

	public function index($hash)
	{
		$pageTitleExtension = 'Reset Password';
		$pageTitle = 'TrendsNZ |  '.$pageTitleExtension;
		
		
		//$item = $this->general_model->checkItem($item);  
		$customID = null;
		$customArray = $this->general_model->checkID($customID); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
		$getServerHost = $this->general_model->getServerHost(); 
		$EmailHidden = $this->general_model->hide_email($getServerHost['specialEmail']);

		$verifyHash = $this->resetuser_model->verifyHash($hash);
		
		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'resetpassword',
			//'itemcode' => $item,
			'productsMenu' => $this->productsMenu,
			'collectionsMenu' => $this->collectionsMenu,
			'premiumMenu' => $this->premiumMenu,
			'worldSourceMenu' => $this->worldSourceMenu,
			'promoShopMenu' =>$this->promoShopMenu,
			'brandingMenu' => $this->brandingMenu,
			'siteLogcheck' =>$this->siteLogcheck,
			'EmailHidden'=>$EmailHidden,
			'getCatSubMenu'=> $this->getCatSubMenu,
			'availAccess' => $availAccess,
			'searchResults' => $searchResults,
			'userIDVerified' => $verifyHash['userID'],
			'userHash'=>$hash
		);
 
		 


		if(count($customArray['themeArray']) == 0  && $this->siteLogcheck['loggedIn'] == 0){
			if($verifyHash['confirmed'] != 1){
				redirect('/');
			}
			$this->load->view('resetpw', $data);
		}else{
			redirect('/');
		}
		
	}

	
	
}
