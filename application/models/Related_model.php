<?php
 
class Related_Model extends CI_Model {

	public function __construct(){ 

		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tablePricing = "productsPricingDEV";
			$this->tableStockCode = "segmentStockCode";
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
		}

		$this->load->model('general_model');  
		 
	}
	 
	
	
	function getRelatedItem($item, $siteLogcheck, $customArray,  $checkAvailCountry){

		$availOnly = $this->general_model->getAvailableProductAccess($siteLogcheck, $checkAvailCountry, $customArray);
		
		$availQuery = $availOnly['availQuery'];
		$currencySort = $availOnly['currencyAvailable'];

	    $valueNew = $item[0]->Category1;
		$queryPage = " ASC";
		$queryStart = "SELECT Code, Name FROM ".$this->tableProducts." LEFT JOIN ".$this->tablePricing." ON ".$this->tablePricing.".Coode = ".$this->tableProducts.".Code AND (".$this->tablePricing.".Currency = '".$currencySort."') AND (".$this->tablePricing.".PriceOrder = '1') WHERE";
		$queryMid = " (Active != 0 AND ".$availQuery."  Category1  LIKE '".$valueNew."' OR Active != 0 AND ".$availQuery." Category2  LIKE '".$valueNew."' OR  Active != 0 AND ".$availQuery."  Category3  LIKE '".$valueNew."' OR  Active != 0 AND ".$availQuery."  Category4 LIKE '".$valueNew."' OR Active != 0 AND ".$availQuery." Category5  LIKE '".$valueNew."' OR Active != 0 AND ".$availQuery."  Category6  LIKE '".$valueNew."') "; 
		$queryData = " ORDER BY (if(".$this->tablePricing.".Price5 !='0.00',".$this->tablePricing.".Price5, if(".$this->tablePricing.".Price4 !='0.00',".$this->tablePricing.".Price4, if(".$this->tablePricing.".Price3 !='0.00',".$this->tablePricing.".Price3, if(".$this->tablePricing.".Price2 !='0.00',".$this->tablePricing.".Price2,".$this->tablePricing.".Price1)))) + ".$this->tablePricing.".AdditionalCost1)";

		$queryOne  =  $queryStart.$queryMid.$queryData;
		$queryTwo = $queryOne.$queryPage; 

			$query = $this->db->query($queryTwo);
			$resultsCount = $query->num_rows();
			$results = $query->result();
			//COunt
			 
		return array('relatedItems'=>$results, 'relatedCount' => $resultsCount) ;
 
		  
 
	}
	
	
	 
	 
	 
}
