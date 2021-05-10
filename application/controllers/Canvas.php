<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Canvas extends CI_Controller {
 

	public function __construct(){ 
		parent:: __construct();  

		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tablePricing = "productsPricingDEV";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
		}


		$this->load->model('home_model');  
		$this->load->model('general_model'); 
		$this->load->helper('download');
		$this->load->model('api_model'); 
		$this->load->model('customsite_model');  
		$this->load->model('skinneduser_model');
		$this->load->model('resetuser_model');
		$this->load->model('checkip_model'); 
		$this->load->model('productsdisplay_model');
		$this->load->library('simpleimage');  
		$this->load->library('phpico'); 
		$this->load->model('category_model'); 
		$this->load->model('favourites_model'); 
		
		$this->siteLogcheck = $this->general_model->getLogcheck();  
	}

	 
	public function  CanvasPost(){
		$request=$this->request();  
		
		$mode = $_POST['mode'];

		/* START REQUEST */
		if($mode == 1) {
			$img = $_POST['imgBase64'];
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$fileData = base64_decode($img);
			//saving
			$uid = uniqid();
			$fileName = "QuickQuoteIMG/".$uid.".png";
			if (file_put_contents($fileName, $fileData)) {
				echo "1~".$uid;
			} else {
				echo "0~".$uid;
			}
		} else {
			if($mode == 2) {
				$img = $_POST['imgName'];
				if(substr($img,15) !== "/QuickQuoteIMG/") {
					unlink($_SERVER['DOCUMENT_ROOT'].$img);
				}
			}
		}

		/* END REQUEST */
		

	}

	

 

	function request()
    {
        $postdata = file_get_contents("php://input");
		$request = json_decode($postdata); 

		return $request;
    }
	
	
}
