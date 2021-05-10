<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {
	

	public function __construct(){
		parent:: __construct();  
		$this->load->model('general_model');  
		$this->load->model('checkip_model'); 
		$this->load->model('search_model');
		$this->load->model('category_model');
		$this->load->model('item_model');
		$this->load->model('productsdisplay_model');
		$this->load->model('changes_model');
		$this->load->model('favourites_model');
		$this->load->model('related_model');
		$this->load->model('recentlyviewed_model');
		$this->load->model('resizer_model');
		 

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

		/* libraries */
		$this->load->library('hitpromo');
		 
		 
	}

	function _remap($item, $customID) {

		//If method exists use it instead of index()
		if(method_exists($this, $item)) return $this->{$item}($customID);

        $this->index($item, $customID);
	}

	public function index($item, $customID)
	{
		$item = $this->general_model->checkItem($item);  
		$customArray = $this->general_model->checkID($customID);
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 

		$getItem = $this->item_model->getItemProducts($item);
		
		//For admin preview link item/100090/preview
		 $getItemDetails = $this->item_model->getItemDetails($item, $this->siteLogcheck, $customArray);

		 //CACHE
		 $this->load->driver('cache', array('adapter'   => 'file')); 
		 if($this->siteLogcheck['userDatas'][0]->userID && count($customArray['themeArray'])==0){
			 $cacheItemProduct = $this->siteLogcheck['userDatas'][0]->userID.'_Itemcache_'.$item;
			 $cacheSearchHeader = $this->siteLogcheck['userDatas'][0]->userID.'_searchHeadercache';
			 $cacheRelatedProduct = $this->siteLogcheck['userDatas'][0]->userID.'_relatedItem_'.$item;
			 $cachePricing = $this->siteLogcheck['userDatas'][0]->userID.'_pricingItem_'.$item;
			  
		 }else{
			 $cacheItemProduct = $checkAvailCountry.'_Itemcache_'.$item; 
			 $cacheSearchHeader = $checkAvailCountry.'_searchHeadercache';
			 $cachePricing = $checkAvailCountry.'_pricingItem_'.$item;
			 if(count($customArray['themeArray']) > 0){ 
				 $cacheItemProduct = $customArray['themeArray'][0]->themeID.'_skinned_Itemcache_'.$item; 
				 $cacheSearchHeader = $customArray['themeArray'][0]->themeID.'_skinned_searchHeadercache';
				 $cacheRelatedProduct = $customArray['themeArray'][0]->themeID.'_skinned_relatedItem_'.$item;  
				 $cachePricing = $customArray['themeArray'][0]->themeID.'_pricingItem_'.$item;
			 }
		 } 
 
		/* if(!$getItemDetails = $this->cache->get($cacheItemProduct)){
			 //For admin preview link item/100090/preview
			 $getItemDetails = $this->item_model->getItemDetails($item, $this->siteLogcheck, $customArray);
			 $this->cache->save($cacheItemProduct, $getItemDetails, 1800); 
			 
		 } */

		if(!$searchResults = $this->cache->get($cacheSearchHeader)){
			$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
			$this->cache->save($cacheSearchHeader, $searchResults, 1200);
		}
 
		 //Remove crap
		 if($this->siteLogcheck['userDatas'][0]->userID){
			 $this->cache->delete($this->siteLogcheck['userDatas'][0]->userID.'_Itemcache_%7B%7BmixmatchCode%7D%7D');
		 }else{
			 $this->cache->delete($checkAvailCountry.'_Itemcache_%7B%7BmixmatchCode%7D%7D');
		 }   
		 //CACHE 

		$getPricingDetails = $this->item_model->getPricingDetails($item, $this->siteLogcheck, $customArray, $getItemDetails, $checkAvailCountry);
 
		$getCompliance = $this->item_model->getCompliance($item); 
		
		//Get the pricing and Product Items for pricing Tabs
		if(!$getPriceProductsForPricing = $this->cache->get($cachePricing)){
			$getPriceProductsForPricing = $this->item_model->getPriceProductsForPricing($item, $this->siteLogcheck, $customArray,  $checkAvailCountry);
			$this->cache->save($cachePricing, $getPriceProductsForPricing, 600);
		}
		
		
		//Get changes log
		$getChangesItem = $this->item_model->getChangesItem($item, $this->siteLogcheck, $customArray,  $checkAvailCountry);

		$getChangeType = $this->changes_model->getChangeType();

		//print_r($getChangesItem);

		//print_r($getPriceProductsForPricing);

		



		if($getItem != 0 || $getItemDetails['productDetails'] != 0){
			$categoryOne = $getItem[0]->Category1;
			$getCategoryName = $this->category_model->getCategoryName($getItem[0]->Category1); 
			$breadcrumbs = $this->category_model->breadCrumbs($getCategoryName,  $customArray, $getItem); 
			
			//Recently viewed
			/* if(count($customArray['themeArray']) == 0 && $this->siteLogcheck['loggedIn'] == 1):
					$savedCookie = $this->recentlyviewed_model->saveCookie($item, $this->siteLogcheck, $customArray); 
			endif; */
		 
		}

		//Variables
		$splitDevCharge = 20;
		$csrMsg = 'Prices not available, please contact your Account Manager for a quote.';
		$notAvailTemp = 'This item is not available for delivery to ';
		//if($this->siteLogcheck['userDatas'][0]->Currency == )

		$getCurrencies = $this->general_model->getCurrencyData();
	 
		foreach($getCurrencies as $rc){ 
			 
			if($this->siteLogcheck['userDatas'][0]->Currency == $rc->currencyName){ 
					$countryVar = $rc->currencyCountry; 
			}
			 
		} 
		if($getItemDetails['productDetails'][0]->availNZ == 0){ 
			$notAvail = $notAvailTemp.$countryVar;
		} 
		if($getItemDetails['productDetails'][0]->availAU == 0){ 
			$notAvail = $notAvailTemp.$countryVar;
		}
		if($getItemDetails['productDetails'][0]->availSG == 0){ 
			$notAvail = $notAvailTemp.$countryVar;
		}
		if($getItemDetails['productDetails'][0]->availMY == 0){ 
			$notAvail = $notAvailTemp.$countryVar;
		}
		 
		 

		/* Get Related Items */ 
		//CACHE  

		if(!$getRelatedItem = $this->cache->get($cacheRelatedProduct)){
			//For admin preview link item/100090/preview
			$getRelatedItem = $this->related_model->getRelatedItem($getItem, $this->siteLogcheck, $customArray,  $checkAvailCountry);
			$this->cache->save($cacheRelatedProduct, $getRelatedItem, 1800); 
			
		}

		/*  CACHE Get AU TRANSIT AND MELBOURNE */
		/* $cacheAUTransit = "auTransitTimes";
		if(!$getAUTransit = $this->cache->get($cacheAUTransit)){ 
			$getAUTransit = $this->item_model->getAUTransitTimes();
			$this->cache->save($cacheAUTransit, $getAUTransit , 8800);  
		}
		
		$cacheMelbourneTransit =  "melbourneTransitTimes";
		if(!$getMelbourneTransit = $this->cache->get($cacheMelbourneTransit)){ 
			$getMelbourneTransit = $this->item_model->getMelbourneTransitTimes();
			$this->cache->save($cacheMelbourneTransit, $getMelbourneTransit , 8800);  
		} */
		 
		/*  CACHE Get AU TRANSIT AND MELBOURNE */

		 

		$pageTitleExtension = $this->general_model->cleanString($getItem[0]->Name);
		$pageTitle = 'TRENDS |  '.$pageTitleExtension;

		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'item',
			'itemcode' => $item,
			'productsMenu' => $this->productsMenu,
			'collectionsMenu' => $this->collectionsMenu,
			'premiumMenu' => $this->premiumMenu,
			'worldSourceMenu' => $this->worldSourceMenu,
			'promoShopMenu' =>$this->promoShopMenu,
			'brandingMenu' => $this->brandingMenu,
			'siteLogcheck' =>$this->siteLogcheck,
			'getCatSubMenu'=> $this->getCatSubMenu,
			'availAccess' => $availAccess,
			'checkAvailCountry'=>$checkAvailCountry,
			'searchResults' => $searchResults,
			'pageTitleExtension'=>$pageTitleExtension,
			'breadcrumbs' => $breadcrumbs,
			'getItemDetails' => $getItemDetails,
			'productItem' => $getItemDetails['productDetails'],
			'customID' => $customID,
			'getCompliance'=>$getCompliance,
			'getPricingDetails' => $getPricingDetails,
			'csrMsg' => $csrMsg,
			'notAvail' => $notAvail,
			'getPriceProductsForPricing' => $getPriceProductsForPricing,
			'splitDevCharge' => $splitDevCharge,
			'getChangesItem' => $getChangesItem,
			'getChangeType' => $getChangeType,
			'getRelatedItem' => $getRelatedItem
			//'getAUTransit' => $getAUTransit,
			//'getMelbourneTransit' => $getMelbourneTransit
		);

	 	//echo $item;
		if(!$item || $item == 'index'){ 
			redirect('/');
		}
		if(strpos($item, 'ID') !== false){
			 redirect('/home/'.$item);
		}

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
					$skinnedUserCheck =   $this->general_model->getSkinnedLogcheck($CustomerNumber, $themeID);  
					$data['skinnedUserCheck'] = $skinnedUserCheck;
				} 
				/* check if skinned user logged in or not */
		}
 
		if($getItem  != 0 && $getItemDetails['productDetails'] == 0){
			$this->load->view('errorpage', $data); 
		}elseif($getItem  == 0 && $getItemDetails['productDetails'] == 0){ 
			redirect('errorpage'.strtoupper($customArray['customID']));
		}else{
			$this->load->view('item', $data);
		} 
		
		
	}

	public function getImageData($customID)
	{
		$data = [];
		$code = $customID[0];
		$item = $this->item_model->getItemProducts($code)[0];
		$imgCount = $item->ImageCount;

		//Generate data for all images
		for ($i=0; $i <= $imgCount; $i++)
		{
			$data[] = [
				'filename' => $code . '-' . $i . '.jpg?' . date('dmY'),
				'caption' => $this->item_model->getCaption($code, $i)
			];
		}

		echo json_encode($data);

		return true;
	}
}
