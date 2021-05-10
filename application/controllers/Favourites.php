<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favourites extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model');  
		$this->load->model('favourites_model');  
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
		
	 
		/* $fullPath =  $_SERVER['DOCUMENT_ROOT'];
		$this->load->library('pdfhtml'); 

		$hello = 'Jeoffy\'s PDF Testing'; 
		$varHtml = '<style type="text/css">@import url("'.$fullPath.'/public/css/bootstrap.css"); @import url("'.$fullPath.'/public/css/tgp-stylesheet.css"); </style>

		 
		<p><img src="'.$fullPath.'/Images/logo.png" class="img-responsive" /></p>
		<h2>'.$hello.'</h2>
		<p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
		<p><a href="#" class="btn btn-primary btn-lg" >Jeof\'s button with style</a></p>
		 
		<table class="table table-items table-striped  table-bordered table-sm" border="0" cellspacing="0" cellpadding="0">
			<thead class="thead-dark">
				<tr>
					<th colspan="6" align="center"><span class="uppercase ng-binding">Unbranded</span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="16%" align="center"> 10 </td>
					<td width="16%" align="center"> 25 </td>
					<td width="16%" align="center"> 50 </td>
					<td width="16%" align="center"> 100 </td>
					<td width="16%" align="center"> 250 </td>
					<td width="16%" align="center"> 500 </td>
				</tr>
			
				<tr>
					<td align="center"> $18.02 </td>
					<td align="center"> $17.62 </td>
					<td align="center"> $17.22 </td>
					<td align="center"> $16.82 </td>
					<td align="center"> $16.42 </td>
					<td align="center"> $16.02 </td>
				</tr>
			</tbody>
		</table>
		';
		$this->dompdf->loadHtml($varHtml);
		$this->dompdf->setPaper('A4', 'portrait');
		$this->dompdf->render(); // output the pdf to browser
		$this->dompdf->stream("testpdf.pdf", array("Attachment"=> false));
		//$this->dompdf->stream("testpdf.pdf" ); download only */
		 
		 



		$pageTitle = 'TRENDS | Favourites';
		
		//$item = $this->general_model->checkItem($item);  
		$customArray = $this->general_model->checkID($customID); 
		$checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
		$availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);
		$searchResults = $this->search_model->searchForm($availAccess, $this->siteLogcheck, $customArray); 
		
		 
		$data = array( 
			'pageTitle' => $pageTitle, 
			'customArray'=>$customArray,
			'angularFile'=> 'favourites', 
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
			/* loggedin datas */ 
			$data['getFavourites'] = $this->favourites_model->getFavouritesItems($this->siteLogcheck['userDatas'][0]->userID, $this->siteLogcheck, $checkAvailCountry, $customArray); 
			
			$data['ImageLibrarySize'] = $this->general_model->getFilesize(1);
			$data['newItemSize'] = $this->general_model->getFilesize(2);
			/* loggedin datas */

			$this->load->view('favourites', $data);
		else: 
			redirect('/'); 
		endif;	
 
	}

	
}
