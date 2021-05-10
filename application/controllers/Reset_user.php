<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_user extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model');  
		$this->load->model('resetuser_model'); 
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


	function _remap($themeID, $hassPw) {
        $this->index($themeID, $hassPw);
	}
	
	public function index($themeID, $hassPw)
	{

		
		//Sample link = http://trends.nz/reset-user/ID1010510006/40fe11027bbff3c683748e786b098d3e.5d5de88d22a00
		

		$hasDomain = 0;
		$pageTitleExtension = ' Reset Skinned User';
		$pageTitle = 'TRENDS |  '.$pageTitleExtension;
		
		//$item = $this->general_model->checkItem($item);  
		$customArray = $this->general_model->checkID($themeID); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
		$getServerHost = $this->general_model->getServerHost(); 
		$EmailHidden = $this->general_model->hide_email($getServerHost['specialEmail']);

		

		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'resetuser',
			//'itemcode' => $item,
			'productsMenu' => $this->productsMenu,
			'collectionsMenu' => $this->collectionsMenu,
			'premiumMenu' => $this->premiumMenu,
			'worldSourceMenu' => $this->worldSourceMenu,
			'promoShopMenu' =>$this->promoShopMenu,
			'brandingMenu' => $this->brandingMenu,
			'siteLogcheck' =>$this->siteLogcheck,
			'EmailHidden'=>$EmailHidden,
			'verifiedEmail'=> false,
			'getCatSubMenu'=> $this->getCatSubMenu,
			'availAccess' => $availAccess,
			'searchResults' => $searchResults
			
		);
 
		//Title for skinned site
		if(count($customArray['themeArray']) > 0){
			if($customArray['themeArray'][0]->Domain != "" || $customArray['themeArray'][0]->Domain != null ):
				$data['pageTitle'] = $customArray['themeArray'][0]->CompanyTag. ' | '.$pageTitleExtension; 
				$hasDomain = 1;
			endif;
 
			if(!$themeID || !$hassPw[0]){
				if($hasDomain == 1){
					redirect('/');
				}else{
					redirect('/home/'.$themeID);
				} 
			}

			$activateForm = 0;
			$resetUserDatas = array('themeID'=> $themeID, 'hassPw'=> $hassPw[0]); 
			$verifiedResetHash = $this->resetuser_model->verifyThemeResetPassword($resetUserDatas);  
			 
			if($verifiedResetHash['exists'] == 1){

				$skinnedUserEmail = $verifiedResetHash['queryResults'][0]->skinnedUserEmail;
				$skinnedUserCompany = $verifiedResetHash['queryResults'][0]->skinnedUserCompany;
				$skinnedUserName = $verifiedResetHash['queryResults'][0]->skinnedUserName;
				$skinnedUserID = $verifiedResetHash['queryResults'][0]->skinnedUserID;
				$skinnedHash = $verifiedResetHash['queryResults'][0]->skinnedHash;
				$customsiteID = $verifiedResetHash['queryResults'][0]->customsiteID;
				$skinnedCustomerNumber = $verifiedResetHash['queryResults'][0]->skinnedCustomerNumber;
				
				$hashCheck = md5($skinnedUserEmail.''.$skinnedUserID).'.'.$skinnedHash; 
				if($hashCheck == $hassPw[0]){
					$activateForm = 1;
					
					$verifiedEmail = $verifiedResetHash['queryResults'][0]->skinnedUserEmail;
					$data['resetUserDatas'] = $resetUserDatas;
					$data['verifiedEmail'] = $verifiedEmail;
					$data['skinnedUserCompany'] = $skinnedUserCompany;
					$data['skinnedUserID'] = $skinnedUserID;
					$data['customsiteID'] = $customsiteID;
				}
 
			}else{
				if($hasDomain == 1){
					redirect('/');
				}else{
					redirect('/home/'.$themeID);
				} 
			}
			 
		}


		if(count($customArray['themeArray']) > 0  || $this->siteLogcheck['loggedIn'] == 0){
			$data['siteLogcheck'] = null;
			$this->load->view('home', $data);
		}else{
			redirect('/');
		}
		
	}

	
	
}
