<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bannerlink extends CI_Controller {
	

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
		$serverPath = $_SERVER['DOCUMENT_ROOT']; 
		$pathUrl = $serverPath.'/Downloads-folder/email/'; 
		
		$json = file_get_contents($pathUrl.'emailbanner.json');  
        $json_emailbanner = json_decode($json,true); 
		
		$getString = substr($json_emailbanner['url'], 0, 2);
 
		//https://bit.ly/2LgKmhU
	 	if($getString == 'ht' || $getString == 'ww'  ){
			$emailBannerUrlvalue = $json_emailbanner['url'];
			redirect($json_emailbanner['url'], 'refresh');
		 }else{

				if($json_emailbanner){
					$emailBannerUrlvalue = $json_emailbanner['url'];
				}else{
					$emailBannerUrlvalue = 'home';
				}
				$domain = $_SERVER['SERVER_NAME'];
				if($emailBannerUrlvalue == 'home'){
					redirect('/');
				}else{
					redirect($emailBannerUrlvalue);
				}  

		 } 	
		 
	}

	
	
}
