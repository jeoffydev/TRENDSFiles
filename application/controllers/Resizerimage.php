<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resizerimage extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model');  
		$this->load->model('resetuser_model'); 
		$this->load->model('checkip_model'); 
		$this->load->model('search_model');
		$this->load->model('productsdisplay_model');  
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

	}

 
	function _remap($var, $num) {
        $this->index($var, $num);
	}
	
	public function index($var, $num)
	{ 
		 
		$numArray = $num;
		$results = 0;

		$serverPath = $_SERVER['DOCUMENT_ROOT']; 
		$pathUrl = $serverPath.'/resizer/470/';
	

		if($var && $numArray[0]){

			$numCount = $numArray[0];
			
			$url = parse_url($_SERVER['REQUEST_URI']); 
			 
			if($url['query'] == "option=1"){

				if($numArray[0] > 0){ 
					for($x = 0; $x <= $numCount; $x++){
						$fileName = $var."-".$x.".jpg";
						$this->resizer_model->index($fileName, 470);
						//echo "CODE XXX ".$fileName." / " .$var. " / ".$x;  
					}
				}else{
					$fileName = $var."-".$numArray[0].".jpg";
					$this->resizer_model->index($fileName, 470);
				}
				$results = 1;
				
			}

			if($url['query'] == "option=2"){
				$code = $var;
				$img =  $numCount;
				$fileName = $code."-".$img.".jpg";
				//echo $fileName;
				unlink($pathUrl.$fileName); 
				$results = 1;
			}


			
		}

		return $results;
		//$this->resizer_model->index()
		
	}

	 
	
	
}
