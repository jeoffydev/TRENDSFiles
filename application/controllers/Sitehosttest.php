<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitehosttest extends CI_Controller {
 
	
	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('home_model');  
		$this->load->model('general_model'); 
		$this->load->helper('download');
 
		$this->siteLogcheck = $this->general_model->getLogcheck();  
 
		$this->name = null;
		$this->data = null; 
		$this->tb = "productsCurrent";
		$this->pT = "productsPricing";
		$this->cT = "productsChanges";
	}

	function _remap($param, $custom) {
        $this->index($param, $custom);
	}

	
	 
	public function  index($param, $custom){ 
		 
		 
		   //phpinfo(); 
			//ZIP------------------------------------------------------------------
			if($param == 'Zip'):
			 
				if($custom[0] == 1){ 
					$this->name = 'Products.zip';
					//$iFileName = base_url()."Images/Products.zip";
					$this->data = file_get_contents("./Images/Products.zip");  
					
				}  
				if($custom[0] == 2){ 
					$this->name = 'New-Products.zip';
					//$iFileName = base_url()."Images/New-Products.zip";
					$this->data = file_get_contents("./Images/New-Products.zip");  
				} 
				if($custom[0] == 3){ 
					$this->name = 'testzip.zip';
					//$iFileName = base_url()."Images/New-Products.zip";
					$this->data = file_get_contents("./Images/testzip.zip");  
				} 
				 
				return force_download($this->name, $this->data); 
				 
			endif;

			 
		 
	}

	 
	 
	
	
}
