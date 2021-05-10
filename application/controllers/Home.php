<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
 

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('home_model'); 
		$this->load->model('general_model'); 
		$this->load->model('checkip_model'); 
		$this->load->model('search_model');  
		$this->load->model('productsdisplay_model');  
		$this->load->model('recentlyviewed_model');


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
		  
		 
		$customArray = $this->general_model->checkID($customID); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		

		//Cache
		$this->load->driver('cache', array('adapter'   => 'file')); 
		if($this->siteLogcheck['userDatas'][0]->userID && count($customArray['themeArray'])==0){
			$cacheHomeBanner = $this->siteLogcheck['userDatas'][0]->userID.'_homebannercache';
			$cacheSearchHeader = $this->siteLogcheck['userDatas'][0]->userID.'_searchHeadercache';
			//$cacheFeaturedBanner = $this->siteLogcheck['userDatas'][0]->userID.'_homefeaturedcache';
		}else{
			$cacheHomeBanner = $checkAvailCountry.'_homebannercache';
			$cacheSearchHeader = $checkAvailCountry.'_searchHeadercache';
			if(count($customArray['themeArray']) > 0){ 
				$cacheHomeBanner = $customArray['themeArray'][0]->themeID.'_skinned_homebannercache';
				$cacheSearchHeader = $customArray['themeArray'][0]->themeID.'_skinned_searchHeadercache';
			}
			//$cacheFeaturedBanner = $checkAvailCountry.'_homefeaturedcache';
		}
		
		if(!$homepageBanner = $this->cache->get($cacheHomeBanner)){
			$homepageBanner = $this->home_model->getMainBanner($this->siteLogcheck, $checkAvailCountry, $customArray);
			$this->cache->save($cacheHomeBanner, $homepageBanner, 1800);
		}

		if(!$searchResults = $this->cache->get($cacheSearchHeader)){
			$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
			$this->cache->save($cacheSearchHeader, $searchResults, 1200);
		}
		 
		 
		 
		$homeFeaturedProducts = $this->home_model->getFeaturedProducts($this->siteLogcheck, $checkAvailCountry, $customArray);

	 
			 
		//var_dump($this->cache->cache_info());
		//print_r($this->cache->get($cacheHomeBanner));
		 
		//$this->cache->clean();

		$pageTitleExtension = 'Home';
		$pageTitle = 'TRENDS |  '.$pageTitleExtension;

		
		
		$data = array( 
			'pageTitle' => $pageTitle,  
			'customArray'=>$customArray,
			'angularFile'=> 'home',
			'productsMenu' => $this->productsMenu,
			'collectionsMenu' => $this->collectionsMenu,
			'premiumMenu' => $this->premiumMenu,
			'worldSourceMenu' => $this->worldSourceMenu,
			'promoShopMenu' =>$this->promoShopMenu,
			'brandingMenu' => $this->brandingMenu,
			'siteLogcheck' =>$this->siteLogcheck,
			'getCatSubMenu'=> $this->getCatSubMenu,
			'availAccess' => $availAccess,
			'searchResults' => $searchResults,
			'homepageBanner' => $homepageBanner,
			'homeFeaturedProducts' => $homeFeaturedProducts,
			'customID' => $customID
		); 

		if(count($customArray['themeArray']) == 0 && $this->siteLogcheck['loggedIn'] == 1  ):
			/* loggedin datas */  
			$data['ImageLibrarySize'] = $this->general_model->getFilesize(1);
			$data['newItemSize'] = $this->general_model->getFilesize(2);

			 
			/* loggedin datas */  
		endif;	

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
		
		

		 

		$this->load->view('home', $data);
		
	}

	/* public function custom($num = null)
	{ 
		 echo $num;
		 echo $this->uri->segment(2, 0);

	} */
	 
	
	public function angularPost(){
		$postdata = file_get_contents("php://input");
		$request = json_decode($postdata);
		
		if($request->option == 1){
			
			$results = $this->home_model->getFeaturedItems();
			$someJSON = json_encode($results);
			echo $someJSON;  
			 
		}
	}

	

}
