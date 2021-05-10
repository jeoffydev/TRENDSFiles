<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usermaintenance extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model');   
		$this->load->model('customsite_model'); 
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



	function _remap($customID) {
        $this->index($customID);
	}

	public function index($customID)
	{
		$pageTitle = 'TRENDS |   User Maintenance';
		
		//$item = $this->general_model->checkItem($item);  
		$customArray = $this->general_model->checkID($customID);  
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
		$customsite = $this->customsite_model->getCustomerData();  
		 
		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'usermaintenance', 
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
		 
		if(count($customArray['themeArray']) == 0 && $this->siteLogcheck['loggedIn'] == 1 && $this->siteLogcheck['userDatas'][0]->userType == 0 && $this->siteLogcheck['userDatas'][0]->CustomerNumber == '10105'):
			/* loggedin datas */  
			$data['ImageLibrarySize'] = $this->general_model->getFilesize(1);
			$data['newItemSize'] = $this->general_model->getFilesize(2);

 

			/* Get Customer Data */
			$CustomerNumber = $this->siteLogcheck['userDatas'][0]->CustomerNumber;
			$CustomerName = $this->siteLogcheck['userDatas'][0]->CustomerName;
			$themeMax = $this->siteLogcheck['userDatas'][0]->ThemedSiteMax;
			 
			$data['CustomerNumber'] = $CustomerNumber;
			$data['CustomerName'] = $CustomerName;
			$data['themeMax'] = $themeMax;
 

			$json_data=array();
			foreach($customsite as $rec)//foreach loop  
			{  
				$json_array['CustomerNumber']=$rec->CustomerNumber;  
				$json_array['CustomerName']= $rec->CustomerName;  
				
				$csr = explode('@', $rec->CSR);  
				$json_array['CSR']=$csr[0]; 
				if($rec->CustomerOnHold == 'N'){
					$CustomerOnHold = 'No';
				}else{
					$CustomerOnHold = 'Yes';
				}  
				$json_array['CustomerOnHold'] = $rec->CustomerOnHold;
				array_push($json_data,$json_array);

				
			} 
			$data['customerData'] = json_encode($json_data,JSON_PRETTY_PRINT); 

			
			/* Get Customer Data */   
			/* loggedin datas */

			 $this->load->view('usermaintenance', $data);
		else: 
			redirect('/'); 
		endif;	
 
	}

	
}
