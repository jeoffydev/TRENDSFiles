<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model');  
		$this->load->model('checkip_model');
		$this->load->model('search_model');  
		$this->load->model('productsdisplay_model');  
		$this->load->model('dashboard_model'); 

		
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
 
		 
		if(count($customArray['themeArray']) == 0  || $this->siteLogcheck['loggedIn'] == 1){
 
			$pageTitleExtension = 'Dashboard';
			$pageTitle = 'TRENDS |  '.$pageTitleExtension;

			if($this->general_model->mobileDetector() == 1){
				redirect('/');
			}
			
			//$item = $this->general_model->checkItem($item);  
			$customArray = $this->general_model->checkID($customID); 
			$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
			$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
			//$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
			$getServerHost = $this->general_model->getServerHost(); 
			$EmailHidden = $this->general_model->hide_email($getServerHost['specialEmail']);
			
			//Cache
			$this->load->driver('cache', array('adapter'   => 'file')); 
			if(!$searchResults = $this->cache->get($cacheSearchHeader)){
				$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
				$this->cache->save($cacheSearchHeader, $searchResults, 1200);
			}
			
			$customerID = $this->siteLogcheck['userDatas'][0]->CustomerNumber;

			
			 
			if($customerID && $this->siteLogcheck['userDatas'][0]->OrderDashboardAccess == 1){
			
				$all = 0;
				$limitOrder = 1000;
				$pagination = 100;
				$displayAll = 0;
				$defaultDisplay = 100; 
				$searchLimit = 500;
 

				//CACHE
				$this->load->driver('cache', array('adapter'   => 'file')); 
				if($this->siteLogcheck['userDatas'][0]->userID && count($customArray['themeArray'])==0){ 
					$cacheSavedDashboard = $this->siteLogcheck['userDatas'][0]->userID.'_'.$customerID.'_dashboard'; 
				} 
				 
				if(!$CustomerOrders = $this->cache->get($cacheSavedDashboard)){  
					$CustomerOrders = $this->dashboard_model->Orders_Custom($customerID, null, $limitOrder);   
					$this->cache->save($cacheSavedDashboard, $CustomerOrders, 120);
				}  
				 
				//$CustomerOrders = $this->dashboard_model->Orders_Custom($customerID, null, $limitOrder);   

				//echo count($CustomerOrders);

				//Save To tracker 
				if($this->siteLogcheck['userDatas'][0]->userID && $this->siteLogcheck['userDatas'][0]->userEmail){
					$this->dashboard_model->OrderDashboardTracker($this->siteLogcheck['userDatas'][0]->userEmail, $this->siteLogcheck['userDatas'][0]->userID);
				}
				
				  
				//Show all or limit
				$start = 0;
				$end = 0;
				if($queryString = $this->input->server('QUERY_STRING')){ 
					if($queryString == "all=1"){
						$defaultDisplay = $limitOrder;
						$displayAll = 1;
					}


					$exp = explode("&", $queryString); 
					if(count($exp) > 0){ 
						foreach($exp as $rx){
							$exp2 = explode("=", $rx);  
							$startEnd[] = $exp2[1]; 
						}  
						//print_r($startEnd);
						 $start = $startEnd[0];
						 $end= $startEnd[1];
					} 
					 
				}
 
				$CustomerOrdersCount = count($CustomerOrders);  

			 

			}else{
				redirect('/dashboardlogin');
			}
			
			 

			$data = array( 
				'pageTitle' => $pageTitle, 
				'customArray'=>$customArray,
				'angularFile'=> 'customer', 
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
				'customerID'=>$customID,
				'CustomerOrders' => $CustomerOrders,
				'CustomerOrdersCount' => $CustomerOrdersCount,
				'pagination' => $pagination,
				'displayAll' => $displayAll,
				'defaultDisplay' => $defaultDisplay,
				'start' =>  $start,
				'end' => $end,
				'searchLimit' => $searchLimit
			);
			
		
			$this->load->view('customer', $data);
		}else{
			redirect('/dashboardlogin');
		}
		

	}

	 

	 
	
}
