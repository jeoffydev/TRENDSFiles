<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model'); 
		$this->load->model('category_model'); 
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



	function _remap($item,   $customID) {
        $this->index($item,  $customID);
	}

	public function index($item,  $customID)
	{

		$getCategoryName = $this->category_model->getCategoryName($item);
		 
		 //print_r($getCategoryName);
		 
		//For Keyword on search
		$url = [];
		$keyword = '';
		$url = parse_url($_SERVER['REQUEST_URI']); 
		if($item == "products"){
			
			 //print_r($url['query']);
			if($url['query']){
				$keyword = $url['query'];

				$stringInvalid = "&fbclid=";
				if (strpos($keyword, $stringInvalid) !== false) {
					$separateString = explode("&fbclid=", $keyword);
					$keyword = $separateString[0];
				} 
				
				if (strpos($keyword, '&rowParam') !== false) {
					 $qr = explode("&", $keyword); 
					 $keyword = $qr[0];
				}

				

				$resultKey = substr($keyword, 0, 10); 
				$keyword = str_replace('%20', ' ', $keyword);
				 
				if($resultKey == "Categories"){
					$keyword = "";
				}
			}
		} 

		
		
		 
		//For Keyword on search
		 $seoMainCat = "";
		 if($getCategoryName['mainCategory']['mainCategoryName']){
			 $seoMainCat = $getCategoryName['mainCategory']['mainCategoryName']. " - ";
		 }
			
		 
		$pageTitleExtensionSEO = $seoMainCat. "" .$getCategoryName['categoryPage'][0]->CategoryName;
		$pageTitleExtension = $getCategoryName['categoryPage'][0]->CategoryName;
		$pageTitle = 'TRENDS |  '.$pageTitleExtensionSEO;

		$item = $this->general_model->checkItem($item);  
		
		$customArray = $this->general_model->checkID($customID);
		
		$checkRedirectToAll=$this->general_model->checkIfAllCategory($item, $customArray); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
		 
		 

		//Cache here
		$this->load->driver('cache', array('adapter'   => 'file')); 
		if($this->siteLogcheck['userDatas'][0]->userID && count($customArray['themeArray'])==0){
			$cacheCategoryItem = $this->siteLogcheck['userDatas'][0]->userID.'_categorycache_'.$item;
			$cacheSearchHeader = $this->siteLogcheck['userDatas'][0]->userID.'_searchHeadercache';
			
			 
		}else{
			$cacheCategoryItem = $checkAvailCountry.'_categorycache_'.$item; 
			$cacheSearchHeader = $checkAvailCountry.'_searchHeadercache';
			if(count($customArray['themeArray']) > 0){ 
				$cacheCategoryItem = $customArray['themeArray'][0]->themeID.'_skinned_categorycache_'.$item; 
				$cacheSearchHeader = $customArray['themeArray'][0]->themeID.'_skinned_searchHeadercache';
			}
		}
		
		if(!$getCategoryProducts = $this->cache->get($cacheCategoryItem)){
			$getCategoryProducts = $this->category_model->getCategoryProducts($item, $this->siteLogcheck, $checkAvailCountry, $customArray);
			$this->cache->save($cacheCategoryItem, $getCategoryProducts, 1200);
		 
			
		} 
		if(!$searchResults = $this->cache->get($cacheSearchHeader)){
			$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
			$this->cache->save($cacheSearchHeader, $searchResults, 1200);
		}
		//Remove crap
		if($this->siteLogcheck['userDatas'][0]->userID){
			$this->cache->delete($this->siteLogcheck['userDatas'][0]->userID.'_categorycache_%7B%7BmixmatchCode%7D%7D');
		}else{
			$this->cache->delete($checkAvailCountry.'_categorycache_%7B%7BmixmatchCode%7D%7D');
			$this->cache->delete($customArray['themeArray'][0]->themeID.'_skinned_categorycache_%7B%7BmixmatchCode%7D%7D');
		}
	 

		//print_r($getCategoryName['categoryPage'][0]->CategoryNum);

		 //print_r($getCategoryProducts);

		//get Colour Search
		$getcolourSearch= $this->productsdisplay_model->getcolourSearch();

		//Breadcrumbs
	 
		$breadcrumbs = $this->category_model->breadCrumbs($getCategoryName,  $customArray); 

		//Get the custom ID 
		if($customArray['themeArray']){
			  if($customArray['themeDomain'] == 1 || $customArray['themeIDskinned'] != "" || $customArray['customID'] != "" ){
				  
					$customID = $customArray['themeIDskinned'];
			  }else{
				 
					$customID = $customID[0];
			  }
		}else{
			 
			$customID = 'index';
		}
		
		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'category',
			'categoryCode' => $item,
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
			'getCategoryProducts' => $getCategoryProducts,
			'customID' => $customID,
			'getcolourSearch' => $getcolourSearch,
			'breadcrumbs' => $breadcrumbs,
			'pageTitleExtension' => $pageTitleExtension,
			'keyword' => $keyword,
			'url' => $url
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
				if($customArray['themeArray'][0]->showPricing == 2 || $customArray['themeArray'][0]->showPricing == 1){
					$CustomerNumber = $customArray['themeArray'][0]->CustomerNumber;
					$themeID = $customArray['themeArray'][0]->themeID;
					$skinnedUserCheck  = $this->general_model->getSkinnedLogcheck($CustomerNumber, $themeID);  
					$data['skinnedUserCheck'] = $skinnedUserCheck;
					 
					 
				} 
				/* check if skinned user logged in or not */

				
		}

		if($getCategoryName['categoryPage'][0]->CategoryNum){
			$this->load->view('category', $data);
		}else{
			$this->load->view('errorpage', $data); 
		}
		
		
		//print_r($data);
	}

	
}
