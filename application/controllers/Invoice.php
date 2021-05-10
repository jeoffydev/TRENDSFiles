<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {

	 
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

		$this->load->library('pdfhtml'); 
		$this->load->library('session'); 
	}

	public function index()
	{  

		/* Add this
	$this->load->library('session'); 
	
    $_SESSION['itemInvoice'] = '
    <p>'.$productItem[0]->Code.' This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
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
    //$this->session->itemInvoice;
	echo '<a href="'.base_url().'invoice" target="_blank">Add to Invoice</a>';
	
	*/
		 
		//From icons.php
		 
		$varHtml=  '<style type="text/css">@import url("'.$fullPath.'/public/css/bootstrap.css"); @import url("'.$fullPath.'/public/css/tgp-stylesheet.css"); </style>'.$this->session->itemInvoice;
		$this->dompdf->loadHtml($varHtml);
		$this->dompdf->setPaper('A4', 'portrait');
		$this->dompdf->render(); // output the pdf to browser
		$this->dompdf->stream("testpdf.pdf", array("Attachment"=> false));

		/* $pageTitleExtension = 'Invoice';
		$pageTitle = 'Trends Collection |  '.$pageTitleExtension; 
		
		$data = array( 
			'pageTitle' => $pageTitle,  
		 
		);  
		$this->load->view('invoice', $data); */
		
	}
}
