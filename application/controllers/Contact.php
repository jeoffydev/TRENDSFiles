<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
	

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
		$pageTitleExtension = 'Contact';
		$pageTitle = 'Trends Collection |  '.$pageTitleExtension;
		
		//$item = $this->general_model->checkItem($item);  
		$customArray = $this->general_model->checkID($customID); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
		$getServerHost = $this->general_model->getServerHost(); 
		$EmailHidden = $this->general_model->hide_email($getServerHost['specialEmail']);
		
		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'contact',
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
			'searchResults' => $searchResults,
			'checkAvailCountry' => $checkAvailCountry
		);
 
		//Title for skinned site
		if(count($customArray['themeArray']) > 0){
			$data['siteLogcheck'] = null;
			if($customArray['themeArray'][0]->Domain != "" || $customArray['themeArray'][0]->Domain != null ):
				$data['pageTitle'] = $customArray['themeArray'][0]->CompanyTag. ' | '.$pageTitleExtension;
			else:
				$data['pageTitle'] = $customArray['themeArray'][0]->CompanyTag. ' | '.$pageTitleExtension;	
			endif;

			/* check if skinned user logged in or not */
			if($customArray['themeArray'][0]->showPricing == 2){
				$CustomerNumber = $customArray['themeArray'][0]->CustomerNumber;
				$themeID = $customArray['themeArray'][0]->themeID;
				$skinnedUserCheck = $this->skinnedSiteLogcheck = $this->general_model->getSkinnedLogcheck($CustomerNumber, $themeID);  
				$data['skinnedUserCheck'] = $skinnedUserCheck;
			} 
			/* check if skinned user logged in or not */

		}
		
	 

		if(count($customArray['themeArray']) > 0  ){
			//If No contact page 
			if($customArray['themeArray'][0]->ContactUsActive == 0){
				if($customArray['themeArray'][0]->Domain){
					redirect('/');
				}else{
					//Redirect if no domain 
					redirect(base_url().strtoupper($customArray['customID']));
				} 
			}

			$this->load->view('contact', $data);
		}else{
			redirect('/');
		}
		
	}

	
	
}
