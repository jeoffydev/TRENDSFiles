<?php
 
class Item_Model extends CI_Model {

	public function __construct(){ 
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tablePricing = "productsPricingDEV";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChanges";
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChanges";
		}

		$this->load->model('productsdisplay_model');
		$this->load->model('general_model');
		$this->load->library('hitpromo');
	}
 
	function getItemProducts($item){

		$query = $this->db->query("SELECT * FROM ".$this->tableProducts." LEFT JOIN ".$this->categoriesTable." ON ".$this->categoriesTable.".CategoryNum=".$this->tableProducts.".Category1  WHERE ".$this->tableProducts.".Code = '".$item."'  ");
		$rowsNum = $query->num_rows();
		if($rowsNum > 0){
			$results = $query->result();
		}else{
			$results = 0;
		}
		return $results;
	}

	function getItemDetails($code, $siteLogcheck, $customArray){
			$active = " AND Active !=  0";  
			$results = array();
			$results['preview'] = 0;
			//print_r($customArray);
			if($siteLogcheck['loggedIn'] == 1 && $customArray['themeArray'] == 0){
				$active = " AND Active !=  0";  

				$link = $_SERVER["REQUEST_URI"];
				if( $siteLogcheck['userDatas'][0]->userType == 0){
					$divided = explode("/", $link); 
					if($divided[3] == "preview"){
						$active = " ";  
						$results['preview'] = 1; 
					} 	
				} 
				 
			}
			
			$query = $this->db->query("SELECT * FROM ".$this->tableProducts." WHERE Code LIKE '".$code."' ".$active."  ");
			$rowsNum = $query->num_rows();
			if($rowsNum > 0){
				$results['productDetails'] = $query->result();
				$resTemp = $query->result();
				if($resTemp[0]->Active == 1 && $results['preview'] == 1){
					$results['preview'] = 2; 
				}
			}else{
				$results['productDetails']  = 0;
			}
			return $results;
	}

	function getPricingDetails($item, $siteLogcheck, $customArray, $getItemDetails, $checkAvailCountry){
	 

		$availNZ = $getItemDetails['productDetails'][0]->availNZ;
		$availAU = $getItemDetails['productDetails'][0]->availAU;
		$availSG = $getItemDetails['productDetails'][0]->availSG;
		$availMY = $getItemDetails['productDetails'][0]->availMY;
		//print_r($getItemDetails['productDetails']);
		$PricingOne = 0;
		$PricingTwo = 0;
		$PricingThree = 0;
		$PricingFour = 0;
		$contactCSR = 2;
		
		if($siteLogcheck['userDatas'][0]->Currency == 'NZD'){
			$Currency = 'NZD';
			$SecondCurrency = 'AUD';
		}
		if($siteLogcheck['userDatas'][0]->Currency == 'AUD'){
			$Currency = 'AUD';
			$SecondCurrency = 'NZD';
		} 
		if($siteLogcheck['userDatas'][0]->Currency == 'SGD'){
			$Currency = 'SGD'; 
		} 
		if($siteLogcheck['userDatas'][0]->Currency == 'MYR'){
			$Currency = 'MYR'; 
		} 
		
		if(count($customArray['themeArray']) > 0){
			if($checkAvailCountry == "availNZ"){
				$Currency = 'NZD'; 
			}
			if($checkAvailCountry == "availAU"){
				$Currency = 'AUD'; 
			}
			if($checkAvailCountry == "availSG"){
				$Currency = 'SGD'; 
			}
			if($checkAvailCountry == "availMY"){
				$Currency = 'MYR'; 
			}
		}
		 
		$queryOne = $this->db->query(" SELECT * FROM ".$this->tablePricing." WHERE Coode = '".$item."' AND Currency LIKE '".$Currency."' AND PriceOrder = '1' ");
		$rowsNumOne = $queryOne->num_rows();
		if($rowsNumOne > 0){
			$PricingOne = $queryOne->result(); 
			 
			foreach($PricingOne as $row){
				if(  $row->Price1 == "" || $row->Price1 == null || $row->Price1 == '0.00'     ){
					$PricingOne = $contactCSR;
				}
			}
		}else{
			$PricingOne = $contactCSR;
		}
		 
		 
		if($siteLogcheck['loggedIn'] == 1 &&  $siteLogcheck['userDatas'][0]->multiCurrency == 1 && count($customArray['themeArray']) == 0){

			$queryTwo = $this->db->query(" SELECT * FROM ".$this->tablePricing." WHERE Coode = '".$item."' AND Currency LIKE '".$SecondCurrency."' AND PriceOrder = '1' ");
			$rowsNumTwo = $queryTwo->num_rows();
			if($rowsNumTwo > 0){
				$PricingTwo = $queryTwo->result();

				foreach($PricingTwo as $row){
					if(  $row->Price1 == "" || $row->Price1 == null || $row->Price1 == '0.00'   ){
						$PricingTwo = $contactCSR;
					}
				}
				 
			}else{
				$PricingTwo = $contactCSR;
			}
			
		} 

	
		//if($PricingOne != 0 || $PricingTwo != 0){
		if($PricingOne != 0  ){
			//NZD user
			if($Currency == 'NZD' ){
					if($availNZ == 0){
						$PricingOne = 0;
					}
					 
					$results = array('pricingnzd' => $PricingOne ); 
			} 
			//AUD user
			if($Currency == 'AUD'  ){
					 
					if($availAU == 0){
						$PricingOne = 0;
					}
					$results = array('pricingaud'=>$PricingOne); 
			 }
			//SGD User
			 if($Currency == 'SGD'  ){
					 
				if($availSG == 0){
					$PricingOne = 0;
				}
				$results = array('pricingsgd'=>$PricingOne); 
			 }
			 
			 //MYR User
			 if($Currency == 'MYR'  ){
					 
				if($availMY == 0){
					$PricingOne = 0;
				}
				$results = array('pricingmyr'=>$PricingOne); 
		 	}

			 

			 //Skinnedsite
			 if(count($customArray['themeArray']) > 0){
				 
					if($Currency == 'NZD' ){
						if($availNZ == 0){
							$PricingOne = 0; 
						} 
						$results = array('pricingnzd' => $PricingOne); 
						
					} 
					if($Currency == 'AUD' ){
						if($availAU == 0){
							$PricingOne = 0; 
						} 
						$results = array('pricingaud'=>$PricingOne); 
					}  
					
					//SGD User
					if($Currency == 'SGD'  ){
							
						if($availSG == 0){
							$PricingOne = 0;
						}
						$results = array('pricingsgd'=>$PricingOne); 
					}
					
					//MYR User
					if($Currency == 'MYR'  ){
							
						if($availMY == 0){
							$PricingOne = 0;
						}
						$results = array('pricingmyr'=>$PricingOne); 
					}

			 }
		}

		$results = $results;  
		 
		return $results;
	}



	function itemIcons($productItem){

		foreach($productItem as $rec)//foreach loop  
		{    
			$results = $this->productsdisplay_model->productsLoop($rec, null, null, null);
		}

		return $results['Icons']; 
	}

	function getCaption($itemcode, $i){

		$resultStockSegmentCheck = $this->db->query("SELECT * FROM segmentStockCode WHERE FGCode = '".$itemcode."' AND Image = '".$i."' ");  
		$rowsNum = $resultStockSegmentCheck->num_rows();

		//$noValue = '<span class="img-toggle" style="opacity: 0">No Value</span>';
		$noValue = null;

		if($rowsNum > 0){
			$resultStockSegment = $resultStockSegmentCheck->result();
		 	if($resultStockSegment[0]->Caption){
				$Caption = ucfirst($resultStockSegment[0]->Caption);
				$results =  $Caption;
			}else{
				/*$Colour = ucfirst($resultStockSegment[0]->Colour);
				if($Colour){ */
					//$results =  '<span class="img-toggle"   data-toggle="tooltip" data-placement="top"   title="'.$Colour.'">'.$Colour.'</span>';
				/*}else{*/
					$results =  $noValue;
				//} 
			}  

			//print_r($resultStockSegment[0]->Caption);

		}else{
			$results =  $noValue;
		}

		return $results;
	}

	function getCompliance($item){
		$results = null;

		$queriesCompliance  = $this->db->query("SELECT * FROM complianceFramework WHERE itemCode='".$item."' ORDER BY sort ASC"); 
		$rowsNum = $queriesCompliance->num_rows();

		if($rowsNum > 0){
			$results = $queriesCompliance->result();
		} 
		return $results;
	}	


	function getPriceProductsForPricing($item, $siteLogcheck, $customArray,  $checkAvailCountry){
		
			$Currency = $this->general_model->getAvailableProductAccess($siteLogcheck, $checkAvailCountry, $customArray);

			$FGCurrency = $Currency['currencyAvailable']; 
			$query1 = $this->db->query("SELECT * FROM ".$this->tableProducts." WHERE Code =".$item. " ");
			$productData = $query1->result();

			$query2 = $this->db->query("SELECT * FROM ".$this->tablePricing." WHERE Coode =".$item." AND Currency LIKE '".$FGCurrency."' ORDER BY PriceOrder ASC");
			$pricingData = $query2->result();


			/* PricingType */
			$query3 = $this->db->query("SELECT * FROM ".$this->tablePricing."  WHERE Coode =".$item."  ORDER BY PriceOrder ASC");
			$pricingType = $query3->result();

			/* Freight Options */ 
			$getDespatch = $productData[0]->despatchLocation; 
			$getfreightOptions = $productData[0]->freightOptions; 

			if($getfreightOptions){
				$freightArray = explode(',', $getfreightOptions); 
				$reqfreight = $this->db->query("SELECT * FROM freightOption WHERE Prim  IN (".implode(',',$freightArray).") AND despatchLocation =  '".$getDespatch."'   ");
				 
			}else{
				$reqfreight = $this->db->query("SELECT * FROM freightOption WHERE   despatchLocation =  '".$getDespatch."'   "); 
			}  
			$freightResults = $reqfreight->result();


			 

			$results = array('productData' => $productData, 'pricingData' => $pricingData, 'pricingType'=>$pricingType,   'freightData' => $freightResults, 'Currency' => $FGCurrency );			

			return $results;

	}


	public function hitPromoTable($hitSKUArray){
		$results = ""; 
		$results .= "<table class='table table-bordered small-table-font table-sm table-striped' border='0' cellspacing='0' cellpadding='0'>
		<thead class='thead-dark'>
			<tr class='text-center'>
				<th >Item</th>
				<th >Quantity</th> 
			</tr>
		</thead>";
		$results .= "<tbody>";

		foreach($hitSKUArray as $item) {
			$results .= '<tr>';
			$results .= '<td>'.  ucwords(strtolower($item['color'])). '</td>';
			$results .= '<td>'.  ucwords(strtolower($item['quantity_available'])). '</td>';
			$results .= '</tr>';  

		} 
		$results .= "</tbody>";
		$results .= "</table>";

		 
		return $results;
	}

	function getChangesItem($item, $siteLogcheck, $customArray,  $checkAvailCountry){

		if($siteLogcheck['loggedIn'] == 1){


			$NZDID = 1;
			$AUDID = 7;
			$SGDID = 13;
			$MYRID = 14; 


				if($siteLogcheck['userDatas'][0]->Currency == "NZD"){
					//$changeTypeID = 1;
					$changeTypeID = $NZDID;
					$NZDID = null;
				}
				if($siteLogcheck['userDatas'][0]->Currency == "AUD"){
					//$changeTypeID = 7;
					$changeTypeID = $AUDID;
					$AUDID = null;
				}
				if($siteLogcheck['userDatas'][0]->Currency == "SGD"){
					//$changeTypeID = 13;
					$changeTypeID = $SGDID;
					$SGDID = null;
				}
				if($siteLogcheck['userDatas'][0]->Currency == "MYR"){
					//$changeTypeID = 14;
					$changeTypeID = $MYRID;
					$MYRID = null;
				}


				$arrayCurrency = array(
					$NZDID, 
					$AUDID, 
					$SGDID, 
					$MYRID
				);
			 
				foreach($arrayCurrency as $c){
					if($c != null || $c != ""){
						$arrs[] = $c;
					}
				}
				$implodes = implode (", ", $arrs);
				$chageTypeFin = "  AND ChangeType  NOT IN (".$implodes.")";
				$resultChanges = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." ".$chageTypeFin." ORDER BY DateChange DESC LIMIT 20");
				 
		}else{
			 
			if($checkAvailCountry == 'availNZ'){
				$changeTypeID = 1;
			}
			if($checkAvailCountry == 'availAU'){
				$changeTypeID = 7;
			}
			if($checkAvailCountry == 'availSG'){
				$changeTypeID = 13;
			}
			if($checkAvailCountry == 'availSG'){
				$changeTypeID = 14;
			}

			$chageTypeFin = ' AND ChangeType = '.$changeTypeID; 
			$resultChanges = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." ".$chageTypeFin." ORDER BY DateChange DESC LIMIT 20");
		} 
 
		
		
		
		$resultChangesFin1 = $resultChanges->result();
		$resultChanges2 = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." ".$chageTypeFin."  AND DateChange >= DATE_SUB(NOW(),INTERVAL 1 YEAR) LIMIT 10");
		$resultChangesFin2 = $resultChanges2->result();
		$resultChangesRows = $resultChanges2->num_rows();

		/*

		if($siteLogcheck['userDatas'][0]->multiCurrency == 1) {
			$resultChanges = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." ORDER BY DateChange DESC LIMIT 10");
			$resultChangesFin1 = $resultChanges->result();
			$resultChanges2 = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." AND DateChange >= DATE_SUB(NOW(),INTERVAL 1 YEAR) LIMIT 10");
			$resultChangesFin2 = $resultChanges2->result();
			$resultChangesRows = $resultChanges2->num_rows();
		 
		} else {
			if($siteLogcheck['userDatas'][0]->Currency == "NZD") {
				$resultChanges = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." AND ChangeType<>7 ORDER BY DateChange DESC LIMIT 10");
				$resultChangesFin1 = $resultChanges->result();
				$resultChanges2 = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." AND ChangeType<>7 AND DateChange >= DATE_SUB(NOW(),INTERVAL 1 YEAR) LIMIT 10");
				$resultChangesFin2 = $resultChanges2->result();
				$resultChangesRows = $resultChanges2->num_rows();
			 
			} else {
				$resultChanges = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." AND ChangeType<>1 ORDER BY DateChange DESC LIMIT 10");
				$resultChangesFin1 = $resultChanges->result();
				$resultChanges2 = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE Code=".$item." AND ChangeType<>1 AND DateChange >= DATE_SUB(NOW(),INTERVAL 1 YEAR) LIMIT 10");
				$resultChangesFin2 = $resultChanges2->result();
				$resultChangesRows = $resultChanges2->num_rows();
				 
			}
		}  */

		


		$results = array('resultChangesOne' =>$resultChangesFin1, 'resultChangesTwo' => $resultChangesFin2,  'resultChangesTwoCount'=> $resultChangesRows  );
		return $results;
	}

	public function getAUTransitTimes(){
		$req = $this->db->query("SELECT Combined, State, Postcode_from FROM auTransitTimes ORDER BY Postcode_from ASC  ");  
		$results = $req->result(); 

		return $results;
	}

	public function getMelbourneTransitTimes(){
		$req = $this->db->query("SELECT Combined, Postcode_from FROM melbourneTransitTimes ORDER BY Postcode_from ASC  ");  
		$results =  $req->result(); 

		return $results;
	}


	public function getHitPromoAPIDatas($hitPromoAPIs, $hitCode){

/*
		if($siteLogcheck['userDatas'][0]->userID && count($customArray['themeArray'])==0){
			$cacheStockWorldSource = $siteLogcheck['userDatas'][0]->userID.'_stockWorldSource_'.$itemcode;
			 
		}else{
			$cacheStockWorldSource = $checkAvailCountry.'_stockWorldSource_'.$itemcode;  
			if(count($customArray['themeArray']) > 0){ 
				$cacheStockWorldSource = $customArray['themeArray'][0]->themeID.'_skinned_stockWorldSource_'.$itemcode;  
			}
		}  
 */
		//Cache here
		$this->load->driver('cache', array('adapter'   => 'file')); 
		$cacheStockWorldSource = "_StockWorldSource_cache_".$hitCode;

		$hitSKU = $hitPromoAPIs;

		if(!$hitSKUArray = $this->cache->get($cacheStockWorldSource)){
			//For admin preview link item/100090/preview
			$hitSKUArray = $this->hitpromo->index($hitSKU); 
			$this->cache->save($cacheStockWorldSource, $hitSKUArray, 1200); 
			
		} 
		
		if($hitSKUArray){
			$results = $this->hitPromoTable($hitSKUArray);
		}else{
			$results = '<p>Please contact your Account Manager for stock availability information.</p>';
		} 


		return $results;
	}

	 
	/*
	function getFeaturedProducts($siteLogcheck, $checkAvailCountry, $customArray){
		$availQuery = " ";
		if($siteLogcheck['userDatas'][0]->Currency != "") {
			$currencySort = $siteLogcheck['userDatas'][0]->Currency;	
			
			if($currencySort == "NZD"){
				$availQuery = "  availNZ = 1 AND ";
			}else{
				$availQuery = "  availAU  = 1 AND ";
			}
			
		} else {
			if($checkAvailCountry == "availNZ") {	
				$currencySort = "NZD";
			} 
			if($checkAvailCountry == "availAU") {
				$currencySort = "AUD";
			} 

			if($currencySort == "NZD"){
				$availQuery = "  availNZ = 1 AND ";
			}else{
				$availQuery = "  availAU  = 1 AND ";
			}
		}
 
		$query = $this->db->query("SELECT * FROM  productsCurrent LEFT JOIN productsPricing ON productsPricing.Coode = productsCurrent.Code AND (productsPricing.Currency = '".$currencySort."') AND (productsPricing.PriceOrder = '1')  WHERE ".$availQuery." featuredItem > 0 AND Active != 0 ORDER BY featuredItem");
		return $query->result();
	} */

 
	
	 
}
