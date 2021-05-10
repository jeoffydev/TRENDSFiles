<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Runcache extends CI_Controller {
	

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



	 

	public function index()
	{
		$pageTitle = 'Trends Collection | Run Cache';
		
		//$item = $this->general_model->checkItem($item);  
		$customArray = $this->general_model->checkID($customID); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
		
		 
		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'catalogues', 
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
			$this->load->driver('cache', array('adapter'   => 'file')); 

			$getTheParam = parse_url($_SERVER['REQUEST_URI']); 
			//print_r($getTheParam);

			/* URL - trends.nz/runcache?transit */
			
			if($getTheParam['query'] == "transit"){
				//AUTransit
				$cacheTransits = 'saveCache_auTransitTimes'; 
				$req = $this->db->query("SELECT Combined, Postcode_from FROM auTransitTimes ORDER BY Postcode_from ASC");  
				$cacheTransitFile = $req->result(); 
				if($cacheTransitFile){
					$this->cache->save($cacheTransits, $cacheTransitFile);
					echo "Transit Good! / ";
				}
				$cacheMelbourne = 'saveCache_melbourneTransitTimes';
				$reqm = $this->db->query("SELECT Combined, Postcode_from FROM melbourneTransitTimes ORDER BY Postcode_from ASC ");  
				$cacheMelbourneFile = $reqm->result(); 
				if($cacheMelbourneFile){
					$this->cache->save($cacheMelbourne, $cacheMelbourneFile);
					echo "Melbourne Good!";
				}
			}else{
				redirect('/');   
			}

			
			

		endif;	
		
		 
 
	}

	
}
