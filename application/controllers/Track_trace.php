<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track_trace extends CI_Controller {
 

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('home_model'); 
		$this->load->model('general_model'); 
		$this->load->model('tracktrace_model'); 
		$this->load->model('checkip_model'); 
		$this->load->model('search_model');
		

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

	function _remap($dhlNum, $trackNum) {
        $this->index($dhlNum, $trackNum);
	}
	
	public function index($dhlNum, $trackNum)
	{  
		
		 

		if(!$dhlNum || !$trackNum[0]){
			redirect('/');
		}
		
		$dhlTrackTrace = array('dhlNumber'=> $dhlNum, 'trackTraceNumber'=>$trackNum[0]);

		$trackTraceRequest = $this->tracktrace_model->getTrackTraceAPI($trackNum[0]); 
		//print_r($trackTraceRequest['consignments'][0]);
		//echo "Etooo " .$trackTraceRequest['consignments'][0];
		 
		if($trackTraceRequest){
			$datas = array(
				'id1' => $dhlNum,
				'id2' => $trackNum[0],  
				'option' => 0,
				'consignments' => $trackTraceRequest['consignments'][0],
				'consignmentCount' => $trackTraceRequest['consignmentCount']
			); 

			$oC = $this->tracktrace_model->getLocationDescription();

			$dataTrackTrace = array(
				'id1' => $dhlNum,
				'id2' => $trackNum[0],  
				'option' => 1,
				'consignments' => $trackTraceRequest['consignments'][0],
				'consignmentCount' => $trackTraceRequest['consignmentCount']
			); 
			$getTrackingDetails = $this->tracktrace_model->getTrackingDetails($dataTrackTrace,  $oC);
		} 
		
		$trackTraceData = $this->tracktrace_model->trackDhlStarTrack($datas); 
		$types = $this->tracktrace_model->consignmentTypes();  
		$stats  = $this->tracktrace_model->statusCodes();  
		$selectHawb = $this->tracktrace_model->selectHawb($dhlNum, 1, $trackNum[0]); 

		$customArray = $this->general_model->checkID($dhlNum); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess); 


		$pageTitle = 'Trends Collection | Track & Trace';
		
		$data = array( 
			'pageTitle' => $pageTitle,  
			 'dhlTrackTrace'=>$dhlTrackTrace,
			 'customArray'=>$customArray,
			'angularFile'=> 'tracktrace',
			'productsMenu' => $this->productsMenu,
			'collectionsMenu' => $this->collectionsMenu,
			'premiumMenu' => $this->premiumMenu,
			'worldSourceMenu' => $this->worldSourceMenu,
			'promoShopMenu' =>$this->promoShopMenu,
			'brandingMenu' => $this->brandingMenu,
			'siteLogcheck' =>$this->siteLogcheck, 
			'stylesheet'=> 'tracktracestylesheet',
			'trackTraceData' => $trackTraceData,
			'datas' => $datas,
			'types'=> $types,
			'stats'=> $stats,
			'oC' => $oC,
			'selectHawb' => $selectHawb,
			'getTrackingDetails' => $getTrackingDetails,
			'getCatSubMenu'=> $this->getCatSubMenu,
			'availAccess' => $availAccess,
			'searchResults' => $searchResults
		); 

		if(count($customArray['themeArray']) == 0 && $this->siteLogcheck['loggedIn'] == 1  ):
			/* loggedin datas */  
			$data['ImageLibrarySize'] = $this->general_model->getFilesize(1);
			$data['newItemSize'] = $this->general_model->getFilesize(2);
			/* loggedin datas */  
		endif;	

		 $this->load->view('tracktrace', $data);
		
	}
 

	

}
