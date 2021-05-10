<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Switchaccount extends CI_Controller {
 

	public function __construct(){ 
		parent:: __construct();  
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
		$this->load->model('contact_model');
		$this->load->model('item_model');  
		$this->load->model('usermaintenance_model');
		$this->load->model('switchaccount_model');
		
		$this->siteLogcheck = $this->general_model->getLogcheck();  

		$this->load->driver('cache', array('adapter'   => 'file')); 
	}

	 
	public function  requestSwitch(){ 
		$request=$this->request();   

		if($request->option == 1){ 
			$id = $request->id;
			$userID = $request->userID;
			if($id && $userID){
				$results = $this->switchaccount_model->findAndSetNewCurrency($id, $userID);
				 
				if($results['secondaryAccountFound'] == 1){
					//Delete search Header cache
					$this->cache->delete($userID.'_searchHeadercache');
					$this->cache->delete($userID.'_homebannercache');

					$expire=time()+60*60*24*30;
					$cookie= array(
						'name'   => 'switchaccount_cookies',
						'value'  => 'yes',
						'expire' => $expire,
					);
					$this->input->set_cookie($cookie);
					$cookie2= array(
						'name'   => 'switchaccountid_cookies',
						'value'  => $id,
						'expire' => $expire,
					);
					$this->input->set_cookie($cookie2);

					echo "1";
				}
				 
			} 		 
					   
		}

		if($request->option == 2){ 
			$userID = $request->userID;
			delete_cookie("switchaccount_cookies"); 
			delete_cookie("switchaccountid_cookies"); 
			//Delete search Header cache
			$this->cache->delete($userID.'_searchHeadercache');
			$this->cache->delete($userID.'_homebannercache');
			echo "1";
		}
	}

	public function request()
    {
        $postdata = file_get_contents("php://input");
		$request = json_decode($postdata); 

		return $request;
    }
				 
	
}
