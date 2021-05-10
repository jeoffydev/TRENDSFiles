<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errorpage extends CI_Controller {
 

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('home_model'); 
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


	public function index()
	{  
		if (strpos($this->uri->segment(4), 'ID') !== false) {
			$customID = $this->uri->segment(4);
		}elseif (strpos($this->uri->segment(3), 'ID') !== false) {
			$customID = $this->uri->segment(3);
		}elseif (strpos($this->uri->segment(2), 'ID') !== false) {
			$customID = $this->uri->segment(2);
		}elseif (strpos($this->uri->segment(1), 'ID') !== false) {
			$customID = $this->uri->segment(1);
			redirect('/home/'.$customID);
		}else{
			$customID = null;
		}
		

		$customArray = $this->general_model->checkID($customID); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 

		$pageTitle = 'TRENDS | Page Error';
		
		$data = array( 
			'pageTitle' => $pageTitle,  
			'customArray'=>$customArray,
			'angularFile'=> 'errorpage',
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
		$this->load->view('errorpage', $data);
	}

	 

}
