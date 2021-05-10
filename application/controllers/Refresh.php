<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refresh extends CI_Controller {
 

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
		/* libraries */
		$this->load->library('hitpromo');

		$this->load->driver('cache', array('adapter'   => 'file'));   

	}

	 

	public function index() 
	{  
		redirect('/');
	}
	/*
	public function cache($userID) 
	{  
		
		//var_dump($this->cache->cache_info());
		$countCache = count($this->cache->cache_info())- 1;
		echo "There are ".$countCache. " cache files in total";

		//echo $userID;
		$cats = 300;
		//Main Categories
		for($i = 0; $i <= $cats; $i++ ){
			//3152_categorycache_0-0
			$catID = $i."-0,  "; 
			$this->cache->delete($userID.'_categorycache_'.$catID);
			//echo $userID.'_categorycache_'.$catID. " /";
		}
		echo "<hr />";
		//Subcategories
		$countSubCat = count($this->productsMenu)-1;
		for($sc = 0; $sc <= $countSubCat; $sc++ ){
			$catID = $this->productsMenu[$sc]->CategoryNum;
			echo $userID.'_categorycache_'.$catID. " / ";
		}
		echo "<pre>";
		print_r($this->productsMenu);
		echo "</pre>";
		
	} */

	public function all() 
	{  
		if($this->siteLogcheck['loggedIn'] == 1  ){ 
			$this->cache->clean();

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

				/* $reqH = $this->db->query("SELECT Code, HitSKU FROM productsCurrent WHERE HitSKU != 0 ");  
				$cacheHitPromoArray = $reqH->result(); 
				if($cacheHitPromoArray){
					 foreach($cacheHitPromoArray as $row){
						 $hitCode = $row->Code;
						 $hitSKU = $row->HitSKU;
						 $cacheHitPromoCode = "_StockWorldSource_cache_".$hitCode;
						 $hitSKUArray = $this->hitpromo->index($hitSKU); 
						 $this->cache->save($cacheHitPromoCode, $hitSKUArray, 1200); 
						 
					 }
				}  */
				/* echo "<pre>";
				print_r($cacheHitPromo);
				echo "</pre>"; */


			redirect('/');
		}else{  
			redirect('/error');
		}
		
	}

	public function sessions() 
	{  
		//$this->session->sess_destroy();
		echo $folder_path =  APPPATH .'sessions';

		$this->load->helper("file");
		$del = delete_files($folder_path);

		if($del){
			echo "deleted";
		}
		redirect('/');

		//

 
	}

	 
	 
	

}
