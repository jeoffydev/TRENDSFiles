<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clearcache extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model');  
		$this->load->model('checkip_model');   
		$this->load->model('search_model');  
		$this->load->model('productsdisplay_model');  

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



	function _remap($customID) {
        $this->index($customID);
	}

	public function index($customID)
	{
		$pageTitle = 'Trends Collection | Clear Browser Cache';
		
		//$item = $this->general_model->checkItem($item);  
		$customArray = $this->general_model->checkID($customID); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
		
		 
		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'clearcache', 
			'productsMenu' => $this->productsMenu,
			'collectionsMenu' => $this->collectionsMenu,
			'premiumMenu' => $this->premiumMenu,
			'worldSourceMenu' => $this->worldSourceMenu,
			'promoShopMenu' =>$this->promoShopMenu,
			'brandingMenu' => $this->brandingMenu,
			'siteLogcheck' =>$this->siteLogcheck,
			'getCatSubMenu'=> $this->getCatSubMenu,
			'availAccess' => $availAccess,
			'searchResults' => $searchResults
		);
		 
		if(count($customArray['themeArray']) == 0 && $this->siteLogcheck['loggedIn'] == 1  ):
			/* loggedin datas */  
			$data['ImageLibrarySize'] = $this->general_model->getFilesize(1);
			$data['newItemSize'] = $this->general_model->getFilesize(2);
			/* loggedin datas */ 
		endif;	
		
		$this->load->view('clearcache', $data);
 
	}

	
}
