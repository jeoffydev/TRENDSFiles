<?php
 
class Productsdisplay_Model extends CI_Model {

	public function __construct(){ 
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableProducts = "productsCurrentDEV";
			$this->tableCategories = "categoriesCurrent";
			$this->OnDemandStockTable = "OnDemandStock";
			$this->additionalOptions = "additionalOptions";
			$this->tablePricing = 'productsPricingDEV';
		} else { 
			$this->tableProducts = "productsCurrent";
			$this->tableCategories = "categoriesCurrent";
			$this->OnDemandStockTable = "OnDemandStock";
			$this->additionalOptions = "additionalOptions";
			$this->tablePricing = 'productsPricing';
		}

		$this->load->model('general_model'); 
		$this->load->model('checkip_model'); 
		$this->load->model('item_model'); 
		$this->load->library('hitpromo');

		$this->siteLogcheck = $this->general_model->getLogcheck();   
		$this->splitDevCharge = 15;
		$this->priceNotAvailable = 'Prices not available, please contact your CSR for a quote.';
	 
	}

	 

	function productsLoop($rec, $siteLogcheck, $customArray, $skinnedUserCheck){
		 

		if($skinnedUserCheck['skinnedLoggedIn'] == 1 || $customArray['themeArray'][0]->showPricing == 1){
			$customs = array('1'=> $customArray['themeArray'][0]->Q1Markup, '2'=> $customArray['themeArray'][0]->Q2Markup, '3'=> $customArray['themeArray'][0]->Q3Markup, '4'=> $customArray['themeArray'][0]->Q4Markup, '5'=> $customArray['themeArray'][0]->Q5Markup, '6'=> $customArray['themeArray'][0]->Q6Markup); 
			$custMarkupBranding = $customArray['themeArray'][0]->BrandingPriceMarkup;
		}else{
			$customs = null;
			$custMarkupBranding = $this->custMarkupBranding();
		} 
		 
		$custMarkups = $this->custMarkups($customs);
		 
		
		if($rec->Price6 != '0') {
			$price2Use = $rec->Price6 * (($custMarkups[6] * 0.01)+1);
		} else {
			if($rec->Price5 != '0') {
				$price2Use = $rec->Price5 * (($custMarkups[5] * 0.01)+1);
			} else {
				if($rec->Price4 != '0') {
					$price2Use = $rec->Price4 * (($custMarkups[4] * 0.01)+1);
				} else {
					if($rec->Price3 != '0') {
						$price2Use = $rec->Price3 * (($custMarkups[3] * 0.01)+1);
					} else {
						if($rec->Price2 != '0') {
							$price2Use = $rec->Price2 * (($custMarkups[2] * 0.01)+1);
						} else {
							if($rec->Price1 != '0') {
								$price2Use = $rec->Price1 * (($custMarkups[1] * 0.01)+1);
							} else {
								$price2Use = "";
							}
						}
					}
				}
			}	
		}

		$CurrencyUsed = "NZD";
		if($siteLogcheck['userDatas'][0]->Currency){
			$CurrencyUsed = $siteLogcheck['userDatas'][0]->Currency;
		}

		if($skinnedUserCheck['skinnedLoggedIn'] == 1 || $customArray['themeArray'][0]->showPricing == 1){
			$getCustomerNumber = $customArray['themeArray'][0]->CustomerNumber;
			 $customerNumber = $this->general_model->getCustomerDataByAccount($getCustomerNumber);
			 if($customerNumber[0]){
				$CurrencyUsed =  $customerNumber[0]->Currency; 
			 } 
		}

		 $currencyAdditionalCost = $CurrencyUsed."UnitPrice";
		 $AdditionalCost1 = $rec->$currencyAdditionalCost; 

		 if(!$rec->$currencyAdditionalCost || $rec->$currencyAdditionalCost == "" || $rec->$currencyAdditionalCost == 0 || $rec->$currencyAdditionalCost == "0.00"){
			$AdditionalCost1 = 0; 
		 } 
		 
		
		if($rec->PriceType == "U"){
			$inclusion = "Branded";
			$priceShow = number_format($price2Use + ($AdditionalCost1 * (($custMarkupBranding * 0.01)+1)), 2);
		}
		if($rec->PriceType == "B"){
			$inclusion = "Branded";
			if($price2Use !== "") {
				$priceShow = number_format($price2Use, 2);
			} else {
				$priceShow = $price2Use;
			}
		}
		if($rec->PriceType == "N"){
			$inclusion = "Unbranded";
			if($price2Use !== "") {
				$priceShow = number_format($price2Use, 2);
			} else {
				$priceShow = $price2Use;
			}
		}
	
		if(is_null($priceShow) == FALSE) {
			 
			if(($siteLogcheck['loggedIn'] == 1 && count($customArray['customerAccount']) == 0) || ($customArray['themeArray'][0]->showPricing == 1 || $skinnedUserCheck['skinnedLoggedIn'] == 1)) {
				if($priceShow !== "") {
					$lowMsg = "<span>".$inclusion." From As Low As </span>";
					$priceFinal = "<br /><span class='font-15 bold'>$".$priceShow. "</span>";
				} 
			}
		}
	
		//$json_array['Name']= $this->general_model->cutTitle(html_entity_decode($rec->Name, ENT_QUOTES)); 
		$json_array['Name']=  html_entity_decode($rec->Name, ENT_QUOTES); 

		if(strlen(html_entity_decode($rec->Name, ENT_QUOTES)) > 23){
			$json_array['Overlap']= 1; 
		}else{
			$json_array['Overlap']= 0; 
		}
		//Get segment Code
		/* $segmentCode = $this->getSegmentStockCode($rec->Code);

		$sc = array();
		if(count($segmentCode) > 0){
			
			for($i = 0; $i <= count($segmentCode); $i++ ){
				if($segmentCode[$i]->Colour != null){
					$sc[$segmentCode[$i]->Colour]=$segmentCode[$i]->Image;
				}
				
			} 
		} */

		//print_r($rec->Colour);

		$json_array['getColour'] = $rec->Image; 

		if($rec->FeaturedImageYes == "Feature"){
			$json_array['getColour'] = $rec->FeaturedImageNumber;
		}else{
			$rec->FeaturedImageYes = null;
			$rec->FeaturedImageNumber = null;
		} 

		 
		 
		//$json_array['getColour'] = $rec->Image;
		$json_array['FullName']=  html_entity_decode($rec->Name, ENT_QUOTES); 
		$json_array['Prim']= $rec->Prim;  
		$json_array['Code']= $rec->Code;  
		$json_array['PrintType1']= $rec->PrintType1; 
		//$json_array['ColourSearchArray']= $sc;  
		$json_array['price2Use']= $lowMsg. '' .$priceFinal;  
		$json_array['CountFeaturedItems'] = count($homeFeaturedProducts); 
		$json_array['Random']= $this->general_model->random();

		$json_array['HitSKU']= 0;
		if($rec->HitSKU > 0){
			$json_array['HitSKU']= $rec->HitSKU;
		}
		

		//Branding
		//$pdfPath = $_SERVER['DOCUMENT_ROOT']."/PDFWires/".$rec->Code.".pdf";
		$pdfPath = $this->getBranding($rec->Code);
		if(file_exists($pdfPath)) {
		   $json_array['brandingExists'] = 1; 
		}else{
		   $json_array['brandingExists'] = 0; 
		}

		/* ICOns */
		$json_arrayIconIsIndent = null;
		$json_arrayIconIsIndentExpress = null;
		$json_arrayIconStatus= null; 
		$json_arrayIconFullColour= null;
		$json_arrayIconsIsMixMatch= null;
		$json_arrayIconEco= null;
		$json_arrayIconRecycle= null;
		$json_arrayIconStatus= null;

		if($rec->IsIndent != "") {
			$lead = "Indent: ".$rec->IsIndent." week lead time.";
			$img = "worldSourceAlt.png";
			$json_arrayIconIsIndent = "<img src='/Images/Statuses/s/".$img."' title='".$lead."' data-toggle='tooltip' data-placement='bottom'    />";
			$active_arrayIcon1 = $lead;
		}
		if($rec->IsIndentExpress != "") {
			$lead = "Indent Express: ".$rec->IsIndentExpress." working day lead time.";
			$img = "worldSource.png";
			$json_arrayIconIsIndentExpress = "<img src='/Images/Statuses/s/".$img."' title='".$lead."' data-toggle='tooltip' data-placement='bottom'    />";
			$active_arrayIcon2 = $lead;
		}
		if($rec->Status=='N') { 
			$json_arrayIconStatus = "<img src='/Images/Statuses/s/new.png' title='New Item.' data-toggle='tooltip' data-placement='bottom'     />";
			$active_arrayIcon3 = 'New Item.';
		}
		if($rec->FullColour=='1') {
			$json_arrayIconFullColour = "<img src='/Images/Statuses/s/fullColour.png' title='Full colour branding available.'  data-toggle='tooltip' data-placement='bottom'   />";
			$active_arrayIcon4 = 'Full colour branding available.';
		}
		if($rec->IsMixMatch=='1') {
			$json_arrayIconsIsMixMatch = "<img src='/Images/Statuses/s/mixMatch.png' title='Mix and match item.'  data-toggle='tooltip' data-placement='bottom'    />";
			$active_arrayIcon5 = 'Mix and match item.';
		}
		 
		if($rec->Eco =='1') {
			$json_arrayIconEco = "<img src='/Images/Statuses/s/eco.png'  title='Eco Friendly' class='ecoicon'  data-toggle='tooltip' data-placement='bottom'   />";
			$active_arrayIcon6 = 'Eco Friendly';
		}
		if($rec->Recycle =='1') {
			$json_arrayIconRecycle= "<img src='/Images/Statuses/s/recycle.png'  title='Recyclable' data-toggle='tooltip' data-placement='bottom'    />";
			$active_arrayIcon7 = 'Recyclable';
		}
		if($rec->Status=='D') {
			$json_arrayIconStatusD = "<img src='/Images/Statuses/s/discontinued.png' title='Discontinued Item – while stocks last.' data-toggle='tooltip' data-placement='bottom'   />";
			$active_arrayIcon8 = 'Discontinued Item – while stocks last.';
		} 

		if($rec->availNZ == '1' && $rec->availAU == '0' ){
			$json_arrayIconavailNZ  = "<img src='/Images/Statuses/m/nzd.png'  title='Available for New Zealand Delivery Only.' data-toggle='tooltip' data-placement='bottom'   />";
			$active_arrayIcon9 = 'Available for New Zealand Delivery Only.';
		} 
		if($rec->availNZ == '0' && $rec->availAU == '1'){
			$json_arrayIconavailAU = "<img src='/Images/Statuses/m/aus.png'  title='Available for Australian Delivery Only.' data-toggle='tooltip' data-placement='bottom'  />";
			$active_arrayIcon10 = 'Available for Australian Delivery Only.';
		} 
 
		 

		/* $json_arrayIcons = array(
			'1' => $json_arrayIconIsIndent, 
			'2' => $json_arrayIconIsIndentExpress,
			'3' => $json_arrayIconStatus, 
			'4' => $json_arrayIconFullColour,
			'5' => $json_arrayIconsIsMixMatch,
			'6' => $json_arrayIconEco,
			'7' => $json_arrayIconRecycle,
			'8' => $json_arrayIconStatusD,
			'9' => $json_arrayIconavailNZ,
			'10' => $json_arrayIconavailAU  
		); */

		$json_arrayIcons =  array(  
		 
			0 => array
				(
					'htm' => $json_arrayIconIsIndent, 'tit' => $active_arrayIcon1, 'num' => 1
				),

			1 => array
				(
					'htm' => $json_arrayIconIsIndentExpress, 'tit' => $active_arrayIcon2, 'num' => 2
				),
			2 => array
				(
					'htm' => $json_arrayIconStatus, 'tit' => $active_arrayIcon3, 'num' => 3
				),
			3 => array
				(
					'htm' => $json_arrayIconFullColour, 'tit' => $active_arrayIcon4, 'num' => 4
				),
			4 => array
				(
					'htm' => $json_arrayIconsIsMixMatch, 'tit' => $active_arrayIcon5, 'num' => 5
				),
			5 => array
				(
					'htm' => $json_arrayIconEco, 'tit' => $active_arrayIcon6, 'num' => 6
				),
			6 => array
				(
					'htm' => $json_arrayIconRecycle, 'tit' => $active_arrayIcon7, 'num' => 7
				),
			7 => array
				(
					'htm' => $json_arrayIconStatusD, 'tit' => $active_arrayIcon8, 'num' => 8
				),
			/*8 => array
				(
					'htm' => $json_arrayIconavailNZ, 'tit' => $active_arrayIcon9, 'num' => 9
				),
			9 => array
				(
					'htm' => $json_arrayIconavailAU, 'tit' => $active_arrayIcon10, 'num' => 10
				)  */

		);
			 

		$json_array['Icons'] = $json_arrayIcons;
		/*
		$json_arrayIconsTitle = array(
			'1' => $active_arrayIcon1, 
			'2' => $active_arrayIcon2,
			'3' => $active_arrayIcon3, 
			'4' => $active_arrayIcon4,
			'5' => $active_arrayIcon5,
			'6' => $active_arrayIcon6,
			'7' => $active_arrayIcon7,
			'8' => $active_arrayIcon8,
			'9' => $active_arrayIcon9,
			'10' => $active_arrayIcon10  
		); 
		$json_array['IconsTitle'] = $json_arrayIconsTitle; */

		/* Icons */

		return  $json_array;
	}

	function getBranding($Code){
		$pdfPath = $_SERVER['DOCUMENT_ROOT']."/PDFWires/".$Code.".pdf";
		return $pdfPath;
	}
	
	function custMarkups($customs=NULL){
		if($customs){
			$customs = $customs;
		}else{
			$customs[1] = 0;
			$customs[2] = 0;
			$customs[3] = 0;
			$customs[4] = 0;
			$customs[5] = 0;
			$customs[6] = 0;
		}
		
		return array('1' => $customs[1], '2' => $customs[2], '3' => $customs[3], '4' =>  $customs[4], '5' => $customs[5], '6' => $customs[6]);
	}

	function custMarkupBranding($customs=NULL){
		if($customs){
			$customs = $customs;
		}else{
			$customs  = 0;
			 
		} 
		return $customs;
	}

	function getProductitem($prim){
			$query = $this->db->query("SELECT * FROM ".$this->tableProducts." WHERE Prim = '".$prim."'   ");
			$results = $query->result();
			return  $results;
	}

	function getPricingItem($code){
			$query = $this->db->query("SELECT Quantity1, Quantity2, Quantity3, Quantity4, Quantity5, Quantity6 FROM productsPricing WHERE Coode = ".$code." AND Currency LIKE 'NZD' AND PriceOrder='1'");
			$results = $query->result();
			if(!$results){
				$query2 = $this->db->query("SELECT Quantity1, Quantity2, Quantity3, Quantity4, Quantity5, Quantity6 FROM productsPricing WHERE Coode = ".$code." AND Currency LIKE 'AUD' AND PriceOrder='1'");
				$results = $query2->result();
			}
			return  $results;
	}


	function getProductStock($code){
			$query = $this->db->query("SELECT * FROM productsStock WHERE Code=".$code." ORDER BY SortCode");
			$results = $query->result();
			return  $results; 
	}

	public function  getOnDemandStock($code){ 
			$query = $this->db->query("SELECT FGCode, RMCode, OnDemandStock FROM ".$this->OnDemandStockTable." WHERE FGCode=".$code." ORDER BY OnDemandStockID ");
			$results = $query->result();
			return  $results; 
	}

	function getSegmentStockCode($code){
		$query = $this->db->query("SELECT * FROM segmentStockCode WHERE FGCode=".$code." ORDER BY segmentID");
		$results = $query->result();
		return  $results; 
	}
	

	function getcolourSearch(){
		$query = $this->db->query("SELECT * FROM colourSearch ORDER BY colourOrder ");
		$results = $query->result();
		return  $results; 
	}

	function getCategories(){
		$query = $this->db->query("SELECT * FROM ".$this->tableCategories." WHERE CategoryNum LIKE '%-0'   ORDER BY CategoryOrder");
		$results = $query->result();
		return  $results; 
	}

	function getSubCategories($subCat){
		$subCatVal = explode("-",$subCat);
		$subCatValue = $subCatVal[0];  
		
		$query = $this->db->query("SELECT * FROM ".$this->tableCategories." WHERE CategoryNum LIKE '".$subCatValue."-%' AND CategoryNum NOT LIKE '".$subCatValue."-0' ORDER BY CategoryName");
		$results = $query->result();
		return  $results;
 
	}


	function getStockDateTimeValue(){
		$query = $this->db->query("SELECT DateTimeValue FROM CustomFormData");
		$results = $query->result();
		return  $results; 
	}

	function quickViewRequest($opts, $prim, $code, $loginUser, $skinnedSite, $skinned, $from = null){

		

		if($opts == 'images'){
			$query = $this->db->query("SELECT  ImageCount FROM ".$this->tableProducts." WHERE Prim = '".$prim."'   ");
			$resultsImage = $query->result();
			$imageCount = $resultsImage[0]->ImageCount; 
			
			$imgArray = array();
			for($i=0; $i <= $imageCount; $i++){
				$imgArray[$i] = $code."-".$i.".jpg";
			}
			$results = $imgArray;
		}

		if($opts == 'details'){

			//***************************************Converted First Prioprity 
			$resultsConverted1 = []; 
			$resultsConverted2 = [];
			$resultsConverted3 = [];

			$queryConverted = $this->db->query("SELECT brandingMethod, brandingArea FROM ".$this->additionalOptions." WHERE    ProductCode = ".$code." AND PricingType='Stock'  ORDER BY orderRow  ASC ");
			$rowsConverted = $queryConverted->num_rows(); 

			$queryConverted2 = $this->db->query("SELECT brandingMethod, brandingArea FROM ".$this->additionalOptions." WHERE    ProductCode = ".$code." AND PricingType='Indent - Air'  ORDER BY orderRow  ASC ");
			$rowsConverted2 = $queryConverted2->num_rows(); 

			$queryConverted3 = $this->db->query("SELECT brandingMethod, brandingArea FROM ".$this->additionalOptions." WHERE    ProductCode = ".$code." AND PricingType='Indent - Sea'  ORDER BY orderRow  ASC ");
			$rowsConverted3 = $queryConverted3->num_rows(); 

			
			$reqConverted4 = $this->db->query("SELECT * FROM ".$this->tablePricing." WHERE Coode = ".$code."   AND ( PricingType='Stock' OR PricingType='Indent - Air' OR PricingType='Indent - Sea')   AND Converted = 1  ");  
			$resultsConverted = $reqConverted4->num_rows();  

	 
			//PricingType(Stock, 'Indent - Air', 'Indent - Sea')

			//If no conversion use the full ProductsCurrentDEV
			$query = $this->db->query("SELECT Prim, Code, Name, Description, Colours, ColoursSecondary, ThirdColours, sizingLine1, sizingLine2, sizingLine3, sizingLine4, Dimension1, Dimension2, Dimension3, PrintType1, PrintType2, PrintType3, PrintType4, PrintType5, PrintType6, PrintType7, PrintType8, PrintType9, PrintType10, PrintDescription1, PrintDescription2, PrintDescription3, PrintDescription4, PrintDescription5, PrintDescription6, PrintDescription7, PrintDescription8, PrintDescription9, PrintDescription10, PenIndent, Packing, cartonLength, cartonWidth, cartonHeight, cartonQuantity, cartonWeight, Materials, availNZ, availAU, availSG, availMY, IsIndent, IsIndentExpress FROM ".$this->tableProducts." WHERE Prim = '".$prim."'   ");
			$resultsItemDetails = $query->result();

			$arraysBrandingFinal = [];
			if($rowsConverted > 0 || $rowsConverted2 > 0 || $rowsConverted3 > 0 || $resultsConverted > 0){ 

				if($rowsConverted > 0){
					$resultsConverted1 = $queryConverted->result();
				}

				if($rowsConverted2 > 0){
					$resultsConverted2 = $queryConverted2->result();
				}

				if($rowsConverted3 > 0){
					$resultsConverted3 = $queryConverted3->result();
				}  
				$resultsConvertedFinal = array(
					'0' => $resultsConverted1,
					'1' => $resultsConverted2,
					'2' => $resultsConverted3
				); 

				for($xb = 0; $xb < count($resultsConvertedFinal); $xb++){ 
					
						for($xb2 = 0; $xb2 < count($resultsConvertedFinal[$xb]); $xb2++){
							$arraysBrandingFinal[] = $resultsConvertedFinal[$xb][$xb2];
						}
					  
				}
				// print_r($arraysBrandingFinal);

				$resultsConvertedCount = count($arraysBrandingFinal);
				//$results['itemDetailsNew'] = $arraysBrandingFinal;
				//Make blank frist
				for($p = 1; $p <= 10; $p++){ 
					$pInc = "PrintType".$p;
					$resultsItemDetails[0]->$pInc = "";

					$pInc2 = "PrintDescription".$p;
					$resultsItemDetails[0]->$pInc2 = "";

				}

				
			 
				/* Get the duplicated Branding *********/
				$getBrandNames = [];
				for($rc = 0; $rc < $resultsConvertedCount; $rc++){ 
					if($arraysBrandingFinal[$rc]->brandingMethod){
						$getBrandNames[$rc] = $arraysBrandingFinal[$rc]->brandingMethod;
					} 
				} 

				//$results["XXXXXX"] = $getBrandNames;   


				$duplicates = array_diff_assoc($getBrandNames, array_unique($getBrandNames)); 
				$duplicates= array_unique($duplicates);
				$resultsDuplicatedBranding = [];
				if(count($duplicates) > 0){
					$x = 0;
					foreach($duplicates as $rowDups){
						if($rowDups){
							$getDuplicated[$x] = $rowDups;
						}
						$x++;
					}  
					$results['getThisDuplicatedBranding']   =    $getDuplicated;
					$resultsDuplicatedBranding   =    $getDuplicated;
				}
				
				/* Get the duplicated Branding *********/


				//Get the Array variables
				$results["createdDuplicatedBranding"] = [];
				for($rc = 0; $rc < $resultsConvertedCount; $rc++){ 

					if($arraysBrandingFinal[$rc]->brandingMethod){  

							if(in_array($arraysBrandingFinal[$rc]->brandingMethod, $resultsDuplicatedBranding)){ 
								$results["countThis"]  =  count($resultsDuplicatedBranding);   
								$results["createdDuplicatedBranding"][$arraysBrandingFinal[$rc]->brandingMethod][$rc] = $arraysBrandingFinal[$rc]->brandingArea;   
								 
							}	
					}
				}		

				 

				
				$results["BlockThisDuplicate"] = []; 
				$results["RefreshMe"] = [];
				$incR = 0; 
				$period = "";
				for($rc = 0; $rc < $resultsConvertedCount; $rc++){
					$rcInc = $rc + 1;  
					$pInc = "PrintType".$rcInc; 
					$pInc2 = "PrintDescription".$rcInc;
					 


					$resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;  

					if(in_array($arraysBrandingFinal[$rc]->brandingMethod, $resultsDuplicatedBranding) == false){

						$pInc2 = "PrintDescription".$rcInc;
						$resultsItemDetails[0]->$pInc2 = "<span style='display:block'> &bull; ".$arraysBrandingFinal[$rc]->brandingArea. "</span>"; 

						$strSeparate = explode ("|", $arraysBrandingFinal[$rc]->brandingArea); 
						if(count($strSeparate) > 1){

							$arrs = "";
							for($sep = 0; $sep < count($strSeparate); $sep++){
								$period = $this->checkifPeriod($strSeparate[$sep]);
								$arrs .= "<span style='display:block'>&bull; ".trim($strSeparate[$sep]).$period. "</span>"; 
							} 

							$resultsItemDetails[0]->$pInc2 = $arrs;
						} 

					}


					
					//Overwrite
					if($arraysBrandingFinal[$rc]->brandingMethod){   
							 

							for($brandx= 0; $brandx < count($resultsDuplicatedBranding); $brandx++){
		
								$brandxInc = $brandx + 1;  
		
								if(count($resultsDuplicatedBranding) > 0 && count($resultsDuplicatedBranding) <= $brandxInc ){ 
									
									for($bl = 0; $bl < $brandxInc; $bl++){   
										
									 
										if($resultsDuplicatedBranding[$bl] == $arraysBrandingFinal[$rc]->brandingMethod  ){   

											$results["RefreshMe"][$rc]++; 
		
											if($results["BlockThisDuplicate"][$bl] < 1   ){   
												
												$resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;  

												$areas = ""; 
												foreach($results["createdDuplicatedBranding"] as $key => $value){
													//$results["XXXXXXXX"][$rc] = $key. " == " . $arraysBrandingFinal[$rc]->brandingMethod;
													if($key == $arraysBrandingFinal[$rc]->brandingMethod){  

														 foreach($value as $ev){  

																$strSeparate = explode (" | ", $ev); 
																if(count($strSeparate) > 1){
																	 
																	$arrs = "";
																	
																	for($sep = 0; $sep < count($strSeparate); $sep++){ 

																		$period = $this->checkifPeriod($strSeparate[$sep]);
																		$arrs .= "<span style='display:block'>&bull; ".trim($strSeparate[$sep]).$period. "</span> "; 
																	} 

																	$areas .= $arrs;
																}else{
																	$period = $this->checkifPeriod($ev);
																	$areas .= "<span style='display:block'> &bull; ".trim($ev).$period. "</span>";
																} 
														 }  
														
													}

												}  

											 
												$resultsItemDetails[0]->$pInc2 =  $areas;   
											
											}else{  
													$resultsItemDetails[0]->$pInc = "...";   
											} 

											$results["BlockThisDuplicate"][$bl]++;  
											
											
										}else{ 
											$results["RefreshMe"][$rc] = 0;  
										}  
		
									}
		
								}
		
							} 
							
							
							



							/*

							 if(count($results["RefreshMe"]) > 0){ 

								$newFresh = [];
								$fr = 0;
								foreach($results["RefreshMe"]  as $value){
									$newFresh[$fr] = $value; 
									$fr++;
								} 

								$results["RefreshMeFresh"] = $newFresh;
								$countLess = count($results["RefreshMeFresh"]) - 1;
								$countLessBefore = $countLess - 1;

								$results["RefreshMeFreshCount"] = $results["RefreshMeFresh"][$countLessBefore];

								if( count($results["RefreshMe"][$rc]) > 0 && $results["RefreshMeFreshCount"]  == 0){
									 $resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;  
								}
							}  */

							
 
					}

					
 
					

					/* Equivalent to: 

					$aa=0;
					$bb=0;
					$cc=0;
					$dd=0;
					$ee=0;
					$ff=0;

					if(count($resultsDuplicatedBranding) > 0 && count($resultsDuplicatedBranding) <= 1){

						if($resultsDuplicatedBranding[0] == $arraysBrandingFinal[$rc]->brandingMethod){ 
							if($aa < 1){ 
								$resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;
							}else{
								$resultsItemDetails[0]->$pInc = "...";
							} 
							$aa++;
						}

					}elseif(count($resultsDuplicatedBranding) > 0 && count($resultsDuplicatedBranding) <= 2){
						if($resultsDuplicatedBranding[0] == $arraysBrandingFinal[$rc]->brandingMethod){

							if($bb < 1){ 
								$resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;
							}else{
								$resultsItemDetails[0]->$pInc = "...";
							} 
							
							$bb++;
						}

						if($resultsDuplicatedBranding[1] == $arraysBrandingFinal[$rc]->brandingMethod){

							if($cc < 1){ 
								$resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;
							}else{
								$resultsItemDetails[0]->$pInc = "...";
							} 
							
							$cc++;
						}

					}elseif(count($resultsDuplicatedBranding) > 0 && count($resultsDuplicatedBranding) <= 3){
						if($resultsDuplicatedBranding[0] == $arraysBrandingFinal[$rc]->brandingMethod){

							if($dd < 1){ 
								$resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;
							}else{
								$resultsItemDetails[0]->$pInc = "...";
							} 
							
							$dd++;
						}

						if($resultsDuplicatedBranding[1] == $arraysBrandingFinal[$rc]->brandingMethod){

							if($ee < 1){ 
								$resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;
							}else{
								$resultsItemDetails[0]->$pInc = "...";
							} 
							
							$ee++;
						}

						if($resultsDuplicatedBranding[2] == $arraysBrandingFinal[$rc]->brandingMethod){

							if($ff < 1){ 
								$resultsItemDetails[0]->$pInc = $arraysBrandingFinal[$rc]->brandingMethod;
							}else{
								$resultsItemDetails[0]->$pInc = "...";
							} 
							
							$ff++;
						}

					}  */



					/* Edit and modify the PrintDescription */
				/*	$pInc2 = "PrintDescription".$rcInc;
					$resultsItemDetails[0]->$pInc2 = "<span style='display:block'> &bull; ".$arraysBrandingFinal[$rc]->brandingArea. "</span>"; 

					$strSeparate = explode ("|", $arraysBrandingFinal[$rc]->brandingArea); 
					if(count($strSeparate) > 1){

						$arrs = "";
						for($sep = 0; $sep < count($strSeparate); $sep++){
							$arrs .= "<span style='display:block'>&bull; ".$strSeparate[$sep]. "</span>"; 
						} 

						$resultsItemDetails[0]->$pInc2 = $arrs;
					} */

			    } //For loop


				
			}
			//***************************************Converted First Prioprity 


			//Cache
			$this->load->driver('cache', array('adapter'   => 'file')); 

			if($loginUser == 1){
				$resultPMS = $this->db->query("SELECT * FROM productsStock WHERE Code=".$code." AND PmsCode IS NOT NULL AND PmsCode !='' ORDER BY SortCode");
				$rowsNum =$resultPMS->num_rows();
				if($rowsNum > 0){
					$results['PMSColours'] = $resultPMS->result(); 
				}else{
					$results['PMSColours'] = null; 
				}
				 
			}else{
				$results['PMSColours'] = null;
				
			}
			$results['itemDetails'] = $resultsItemDetails;
			//Make cache for details
			$detailsCache =  $code.'_detailsCache';
			if(!$results['itemDetails'] = $this->cache->get($detailsCache)){
				$results['itemDetails'] = $resultsItemDetails;
				//Refresh and update every 300 is 5 minutes
				$this->cache->save($detailsCache, $results['itemDetails'], 600);
			}

			$results['itemDetails'][0]->availCountryDetails = null;
			if($results['itemDetails'][0]->availNZ == 0 || $results['itemDetails'][0]->availAU == 0 || $results['itemDetails'][0]->availSG == 0 || $results['itemDetails'][0]->availMY == 0){
				//$results['itemDetails'][0]->availCountryDetails = "ETO YUN " .$results['itemDetails'][0]->availNZ;
				$nz = null;
				$au = null;
				$sg = null;
				$my = null;

				$getCurrencyData = $this->general_model->getCurrencyData();

				if($results['itemDetails'][0]->availNZ == 0){
					$nz = $getCurrencyData[0]->currencyCountry;
				}
				if($results['itemDetails'][0]->availAU == 0){
					$au = $getCurrencyData[1]->currencyCountry;
				}
				if($results['itemDetails'][0]->availSG == 0){
					$sg = $getCurrencyData[2]->currencyCountry;
				}
				if($results['itemDetails'][0]->availMY == 0){
					$my = $getCurrencyData[3]->currencyCountry;
				}
				/* Temporary Remove for now the SGD AND MYR */
				$arrsCount = array(
					'nz' => $nz,
					'au' => $au,
					//'sg' => $sg,
					//'my' => $my
				); 
				foreach($arrsCount as $rowAvails){
					if($rowAvails !== null){
						$arrayCountriesAvail[] = $rowAvails;
					}
				}
				$finalCountry = $this->make_list($arrayCountriesAvail);
				if($finalCountry){
					$results['itemDetails'][0]->availCountryDetails = "This item is not available for delivery to " .$finalCountry. ".";
				}else{
					$results['itemDetails'][0]->availCountryDetails = null;
				} 
				
			}

			$varArray = [
				"IsIndent" => $results['itemDetails'][0]->IsIndent,
				"IsIndentExpress" => $results['itemDetails'][0]->IsIndentExpress
			];

			$results['itemDetails'][0]->IsIndentALLLLLL = $varArray;

			if($results['itemDetails'][0]->PrintType1){
				$results['itemDetails'][0]->PrintType1Popup = trim($results['itemDetails'][0]->PrintType1);
			}
			$results['itemDetails'][0]->PrintType1 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType1), $varArray);
			
			if($results['itemDetails'][0]->PrintType2){
				$results['itemDetails'][0]->PrintType2Popup = trim($results['itemDetails'][0]->PrintType2);
			}
			$results['itemDetails'][0]->PrintType2 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType2), $varArray);

			if($results['itemDetails'][0]->PrintType3){
				$results['itemDetails'][0]->PrintType3Popup = trim($results['itemDetails'][0]->PrintType3);
			}
			$results['itemDetails'][0]->PrintType3 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType3), $varArray);

			if($results['itemDetails'][0]->PrintType4){
				$results['itemDetails'][0]->PrintType4Popup = trim($results['itemDetails'][0]->PrintType4);
			}
			$results['itemDetails'][0]->PrintType4 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType4), $varArray);

			if($results['itemDetails'][0]->PrintType5){
				$results['itemDetails'][0]->PrintType5Popup = trim($results['itemDetails'][0]->PrintType5);
			}
			$results['itemDetails'][0]->PrintType5 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType5), $varArray);

			if($results['itemDetails'][0]->PrintType6){
				$results['itemDetails'][0]->PrintType6Popup = trim($results['itemDetails'][0]->PrintType6);
			}
			$results['itemDetails'][0]->PrintType6 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType6), $varArray);

			if($results['itemDetails'][0]->PrintType7){
				$results['itemDetails'][0]->PrintType7Popup = trim($results['itemDetails'][0]->PrintType7);
			}
			$results['itemDetails'][0]->PrintType7 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType7), $varArray);

			if($results['itemDetails'][0]->PrintType8){
				$results['itemDetails'][0]->PrintType8Popup = trim($results['itemDetails'][0]->PrintType8);
			}
			$results['itemDetails'][0]->PrintType8 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType8), $varArray);

			if($results['itemDetails'][0]->PrintType9){
				$results['itemDetails'][0]->PrintType9Popup = trim($results['itemDetails'][0]->PrintType9);
			}
			$results['itemDetails'][0]->PrintType9 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType9), $varArray);

			if($results['itemDetails'][0]->PrintType10){
				$results['itemDetails'][0]->PrintType10Popup = trim($results['itemDetails'][0]->PrintType10);
			}
			$results['itemDetails'][0]->PrintType10 = $this->underlineBrand(trim($results['itemDetails'][0]->PrintType10), $varArray);

			//Clean Description
			$results['itemDetails'][0]->Description = $this->general_model->cleanString($results['itemDetails'][0]->Description);

			$results['itemDetails'][0]->Dimension1 = $this->general_model->DimensionCleaner($results['itemDetails'][0]->Dimension1);
			$results['itemDetails'][0]->Dimension2 = $this->general_model->DimensionCleaner($results['itemDetails'][0]->Dimension2);
			
		   // print_r($results['itemDetails']);

		}

		if($opts == 'stock'){
			$productArray = $this->getProductitem($prim);

			//print_r($productArray[0]->OnDemandStock);
			/* Get the OnDemand Column value */
			$OnDemandStockLevel = $productArray[0]->OnDemandStock;

			$whoops = "no";
			$divMoreActive = 0;
			$divMore = "";
			$divMoreClose = "";
			$divMoreClose2 ="";
			$this->load->driver('cache', array('adapter'   => 'file')); 
			
			if($productArray[0]->HitSKU == 0){
					$results = ""; 

					$productStock = $this->getProductStock($code);
					$countStock = count($productStock);
					$pricingArray = $this->getPricingItem($code); 

					 

					/* Change the heading */
					if($OnDemandStockLevel == 1){
						$Ondemandstock = $this->getOnDemandStock($code); 
					 

						$TitleQty = "In Stock";
						$TitleNextShipment = "On Demand";

					}else{
						$TitleQty = "In Stock";
						$TitleNextShipment = "Next Shipment";
					}
					 

					//Not logged In Users
					if($loginUser == 0 || $loginUser == '' || $skinnedSite == 1){

						
						if($productArray[0]->StockComment){
							$results .= "<p>" .$productArray[0]->StockComment. "</p>";
						}
					
						if ($pricingArray) {
							$pb5 = $pricingArray[0]->Quantity6; 
							if($pb5 == 0){
								$pb5 = $pricingArray[0]->Quantity5; 
							}
						} else {
							$whoops = "yes";	
						}
 

						if($countStock != 0){
							$hideTable = " ";
							if($countStock == 1){
								 if($productStock[0]->Quantity == 0 && $productStock[0]->FutureAvailableQty == 0){
									//$hideTable = "display:none";
								 }
							} 

							$results .= "<table class='table table-bordered small-table-font table-sm table-striped' border='0' cellspacing='0' cellpadding='0' style='".$hideTable."'>
							<thead class='thead-dark'>
								<tr>
									<th >Item</th>
									<th > ".$TitleQty."</th>
									<th >".$TitleNextShipment."</th>
								</tr>
							</thead>";
							$results .= "<tbody>";
							 
							$x=0;
							foreach($productStock as $row){
								//$results .= $row->SortCode;
								$results .= "<tr>";
								if($row->SortCode){
									
									$results .= "<td> ".$row->PartName.  "</td>";

									$QtyCurrent = $row->Quantity; 
									if ($whoops == "no") {
										if ($QtyCurrent >= $pb5) { 
											 //echo "ONE";
											$QtyFinal= number_format($this->checkTotalRoundUp($pb5))."+";
										} else {
											//echo "TWO";
											//echo number_format($QtyCurrent);
											$QtyFinal= number_format($this->checkTotalRoundUp($QtyCurrent));
										}
									}
									if($QtyCurrent == 0){
										$QtyFinal = " - ";
									}
									$results .= "<td> ".$QtyFinal.  " </td>";

									$divMore = "";
									$divMoreClose = "";
									$divMoreClose2 ="";

									if($row->DueDate == '1900-01-01 00:00:00') {
										$nextShipment = "-";
									} else {
										 

										$nextShipment = $this->productStockAvailableFutureDate($row->DueDate);
										
									} 
									/* On Demand Stock or Next Shipment */ 
									if($OnDemandStockLevel == 1){
										
										foreach($Ondemandstock as $rowstock){ 
											if($row->ComponentCode == $rowstock->RMCode){
												$RMCode = $rowstock->RMCode;
												$OndemandstockValue = $rowstock->OnDemandStock;  
												if($OndemandstockValue == 0 || $OndemandstockValue == ""){
													$OndemandstockValue = "-";
												} 
											}
										}

										$results .= "<td> ".$OndemandstockValue." </td>";

									}else{ 
										$results .= "<td> ".$nextShipment."</td>";
									}
									
 
								}
								$results .= "</tr>";
								 
								$x++;
							}
							$results .= "</tbody>";
							$results .= "</table>";

							$results .= "<p style='".$hideTable."'><small>" .$this->lastUpdated()."</small></p>";
							 
							
						}

					} 
					//Not logged In Users


					//If logged In Users
					if($loginUser == 1  &&  $skinnedSite == 0){

						if($productArray[0]->StockComment){
							$results .= "<p>" .$productArray[0]->StockComment. "</p>";
						}

						if($countStock != 0){

							$hideTable = " ";
							if($countStock == 1){
								if($productStock[0]->Quantity == 0 && $productStock[0]->FutureAvailableQty == 0){
									//$hideTable = "display:none";
								 }

								 if($productStock[0]->SortCode == 0){
									 $hideTable = "display:none";
								 }

							} 
							$results .= "<table class='table table-bordered small-table-font table-sm table-striped' border='0' cellspacing='0' cellpadding='0' style='".$hideTable." '>
							<thead class='thead-dark'>
								<tr>
									<th  width='250' >Item</th>
									<th   width='150' > ".$TitleQty."</th>
									 
									<th width='250' >".$TitleNextShipment."</th>
								</tr>
							</thead>";
							$results .= "<tbody>";

							$x=0;
							$divMoreActive = 0;
							 
							 
							foreach($productStock as $row){ 
								$results .= "<tr>";
								if($row->SortCode){
									
									$results .= "<td> ".$row->PartName.  "</td>";

									if($row->Quantity < 1) {
										$QtyFinal = "-";
									} else { 
										$QtyFinal = number_format($this->checkTotalRoundUp($row->Quantity));
									} 
									if($row->Quantity == 0){
										$QtyFinal = " - ";
									}
									$results .= "<td> ".$QtyFinal.  "</td>";


									$futureStock = ""; 
									$futureStock2 = "";
									$futureStock3 = "";
									$nextShipment2 = "";
									$nextShipment3 = "";
									$divMore = "";
									$divMoreClose = "";
									$divMoreClose2 ="";

									if($row->DueDate == '1900-01-01 00:00:00') {
										$nextShipment = "-";
									} else { 
										if($row->FutureAvailableQty > 0){ 
											$nextShipment = number_format($this->checkTotalRoundUp($row->FutureAvailableQty)). " - ";
											$futureStock = number_format($this->checkTotalRoundUp($row->FutureAvailableQty)). " - ";
										}

										$nextShipment = $this->productStockAvailableFutureDateLogin($row->DueDate); 
										
									}

									//Future 2
									if($row->DueDate2 == '1900-01-01 00:00:00') {
										$nextShipment2 = " ";
										$futureStock2= "";
									} else { 

											if($row->FutureAvailableQty2 > 0){ 
												$nextShipment2 = number_format($this->checkTotalRoundUp($row->FutureAvailableQty2)). " - ";
												$futureStock2 = number_format($this->checkTotalRoundUp($row->FutureAvailableQty2)). " - ";
											}

											$nextShipment2 = $this->productStockAvailableFutureDateLogin($row->DueDate2); 

											//Future 3
											if($row->DueDate3 == '1900-01-01 00:00:00') {
												$nextShipment3 = " ";
												$futureStock3= "";
											} else { 
												if($row->FutureAvailableQty3 > 0){ 
													$nextShipment3 = number_format($this->checkTotalRoundUp($row->FutureAvailableQty3)). " - ";
													$futureStock3 = number_format($this->checkTotalRoundUp($row->FutureAvailableQty3)). " - ";
													$futureStock3 = "<br />".$futureStock3;
												}

												$nextShipment3 = $this->productStockAvailableFutureDateLogin($row->DueDate3);   
											}

											
											 
												/* Toggle */	
													$divMore = '<div class="parentStock">
														<a class="accordion-toggle d-block cursorpoint text-info" > 
														  '; 
													$divMoreClose = '<i class="fa fa-plus pull-right" style="position:relative; top:3px"></i></a>
													<div class="child_2" style="display:none">  ';
													$divMoreClose2 = '</div>
														</div> 
													</div>
													
													
													
													';   
										
									}
									
									
									 /* On Demand Stock or Next Shipment */ 
									if($OnDemandStockLevel == 1){
										
										foreach($Ondemandstock as $rowstock){ 
											if($row->ComponentCode == $rowstock->RMCode){
												$RMCode = $rowstock->RMCode;
												$OndemandstockValue = $rowstock->OnDemandStock;  
												if($OndemandstockValue == 0 || $OndemandstockValue == ""){
													$OndemandstockValue = "-";
												} 
											}
										}

										$results .= "<td> ".$OndemandstockValue." </td>";
										
									}else{ 
											$results .= "<td>  ".$divMore."".$futureStock."  ".$nextShipment.  "".$divMoreClose."".$futureStock2."  ".$nextShipment2.  "".$futureStock3."  ".$nextShipment3.  "".$divMoreClose2."</td>"; 	
									}
									 
									
									
								}
								$results .= "</tr>";
								$x++;
							}
							$results .= "</tbody>";
							$results .= "</table>";
							$results .= "<p style='".$hideTable."'><small>" .$this->lastUpdated()."</small></p>";
							 

						}

					}
					//If logged In Users

					 

					 $resultStock =  $results;
					 
					//Make cache for stocks
				 
					
					$detailsStockTableCache =  $code.'_StockTableCache_'.$loginUser;
					if(!$results = $this->cache->get($detailsStockTableCache)){
						$results  = $resultStock;
						//Refresh and update every 300 is 5 minutes
						$this->cache->save($detailsStockTableCache, $results, 600);
					}  
 
			}else{
				//$results = $this->getMessageNonHitPromo();
				$cacheStockWorldSource = "_StockWorldSource_cache_".$code;
				$hitSKU = $productArray[0]->HitSKU;

				if(!$hitSKUArray = $this->cache->get($cacheStockWorldSource)){
					//For admin preview link item/100090/preview
					$hitSKUArray = $this->hitpromo->index($hitSKU); 
					$this->cache->save($cacheStockWorldSource, $hitSKUArray, 1200); 
					
				} 
				
				if($hitSKUArray){
					$results = $this->item_model->hitPromoTable($hitSKUArray);
				}else{
					$msgHitNone = 'Please contact your Account Manager for stock availability information.';
					$results = $msgHitNone;
				}   
			} /*else{

			 
				if($from == 'item'){
					 //print_r($this->hitpromo->index($productArray[0]->HitSKU));
					 
				}
				
			}  */
			
		}

		if($opts == 'pricing'){
			//
			//$results = $skinned;
			//" / My Avail = " .$Currency['MyAccess'];
			$Currency = $this->getMyCurrency($skinned);
			$query = $this->db->query("SELECT * FROM productsPricing WHERE Coode =".$code." AND Currency LIKE '".$Currency['MyCurrency']."' AND PriceOrder = 1 ORDER BY PriceOrder ASC", 0);
			$resultspricing = $query->result(); 


			/** UPGRADE ADDITIONAL COSTS********************************************** */

			//Get the main Pricing type
			if($resultspricing[0]->PricingType){
				$PricingType = $resultspricing[0]->PricingType;
			}else{
				$PricingType = "Stock";
			}

			$reqAdditionalOptions = $this->db->query("SELECT * FROM ".$this->additionalOptions." WHERE ProductCode = '".$code."' AND PricingType = '".$PricingType."' ORDER BY orderRow ASC "); 
			$reqAdditionalOptionsArrays = $reqAdditionalOptions->result(); 

			 //print_r($reqAdditionalOptionsArrays);


			$adds1 = "<table class='table text-center table-bordered small-table-font table-sm table-striped' border='0' cellspacing='0' cellpadding='0'>
										<thead class='thead-dark'>
											<tr>
												<th colspan='3' > ADDITIONAL COSTS </th> 
											</tr>
										</thead>";
			$adds2 = "<tbody>";

			$adds3 = "<tr > <td width='36%'>&nbsp; </td>
										<td width='14%' class='smalltd' > Per Unit </td>
										<td width='14%' class='smalltd'>Setup  </td> 
										</tr>";

			$adds4 =  "</tbody>";
			$adds5 = "</table>";
							
			 
			//Logged in user
			if($loginUser == 1  ||  $skinnedSite == 0){
				 
				if($resultspricing){  // If pricing exists


					if($resultspricing[0]->Price1  ){ 

							$results = "<strong>Pricing - " .$Currency['MyCurrency']. "  </strong>";
						
							$results .= "<table class='table text-center table-bordered small-table-font table-sm table-striped' border='0' cellspacing='0' cellpadding='0'>
							<thead class='thead-dark'>
								<tr>
									<th colspan='6' >".strtoupper($resultspricing[0]->PrimaryPriceDes)."</th> 
								</tr>
							</thead>";
							$results .= "<tbody>";

							foreach($resultspricing as $row){

									$Quantity1 = '';
									$Quantity2 = '';
									$Quantity3 = '';
									$Quantity4 = '';
									$Quantity5 = '';
									$Quantity6 = '';

									if($row->Price1 > 0){
										$Quantity1 = $row->Quantity1;
										$Price1 = "$".$row->Price1;
									}
									if($row->Price2 > 0){
										$Quantity2 = $row->Quantity2;
										$Price2 = "$".$row->Price2;
									}
									if($row->Price3 > 0){
										$Quantity3 = $row->Quantity3;
										$Price3 = "$".$row->Price3;
									}
									if($row->Price4 > 0){
										$Quantity4 = $row->Quantity4;
										$Price4 = "$".$row->Price4;
									}
									if($row->Price5 > 0){
										$Quantity5 = $row->Quantity5;
										$Price5 = "$".$row->Price5;
									}
									if($row->Price6 > 0){
										$Quantity6 = $row->Quantity6;
										$Price6 = "$".$row->Price6;
									}
									
									$results .= "<tr>";
									$results .= "<td width='15%'> ".$Quantity1.  "</td>";
									$results .= "<td width='15%'> ".$Quantity2.  "</td>";
									$results .= "<td width='15%'> ".$Quantity3.  "</td>";
									$results .= "<td width='15%'> ".$Quantity4.  "</td>";
									$results .= "<td width='15%'> ".$Quantity5.  "</td>";
									$results .= "<td width='15%'> ".$Quantity6.  "</td>";
									$results .= "</tr>";

									$results .= "<tr>";
									$results .= "<td> ".$Price1.  "</td>";
									$results .= "<td> ".$Price2.  "</td>";
									$results .= "<td> ".$Price3.  "</td>";
									$results .= "<td> ".$Price4.  "</td>";
									$results .= "<td> ".$Price5.  "</td>";
									$results .= "<td> ".$Price6.  "</td>";
									$results .= "</tr>";
							}
							
							$results .= "</tbody>";
							$results .= "</table>";


							//For additional cost Quick View Converted Priority First


							

							if(count($reqAdditionalOptionsArrays) > 0){

								/********* Converted ***************/
								$reqAdditionalCount = count($reqAdditionalOptionsArrays); 

								$results .= $adds1;
								$results .= $adds2; 
								$results .= $adds3; 

								foreach($reqAdditionalOptionsArrays as $rowUpgradeAdds){

									if($rowUpgradeAdds->costDescription){
										$results .= "<tr>";
										$AdditionalCostDescription = $rowUpgradeAdds->costDescription;
										$AdditionalCostNum = "$".$rowUpgradeAdds->{$Currency['MyCurrency']."UnitPrice"};
										$SetupChargeNum = "$".$rowUpgradeAdds->{$Currency['MyCurrency']."OrderPrice"};

										if($rowUpgradeAdds->{$Currency['MyCurrency']."UnitPrice"} == 0){
											$AdditionalCostNum = '';
										}
										if($rowUpgradeAdds->{$Currency['MyCurrency']."OrderPrice"} == 0){
											$SetupChargeNum = '';
										}

										$results .= "<td class='text-left'> ".$AdditionalCostDescription;  
										if($rowUpgradeAdds->brandingArea){
											$results .= "<small  style='line-height:1.2; display:block'><i> ".$rowUpgradeAdds->brandingArea." </i></small> ";
										} 
										$results .= "</td>";
										$results .= "<td> ".$AdditionalCostNum." </td>";	
										$results .= "<td> ".$SetupChargeNum." </td>";	
										$results .= "</tr>"; 
									} 

								}

								$results .= $adds4;
								$results .= $adds5; 

								/* COnverted  **************************/
		
							}else{

									if($resultspricing[0]->AdditionalCostDesc1):

										$results .= $adds1;
										$results .= $adds2; 
										$results .= $adds3;

										foreach($resultspricing as $row2){
											
											$AdditionalCostDescription = '';
										
											for($i=1;$i<13;$i++) {  
												
												//Additional Cost
												$AdditionalCostDesc = 'AdditionalCostDesc' . $i;
												$AdditionalCost = 'AdditionalCost' . $i;
												$SetupCharge = 'SetupCharge' . $i;
												if($row2->$AdditionalCostDesc){
													$results .= "<tr>";
													$AdditionalCostDescription = $row2->$AdditionalCostDesc;
													$AdditionalCostNum = "$".$row2->$AdditionalCost;
													$SetupChargeNum = "$".$row2->$SetupCharge;

													if($row2->$AdditionalCost == 0){
														$AdditionalCostNum = '';
													}
													if($row2->$SetupCharge == 0){
														$SetupChargeNum = '';
													}

													$results .= "<td class='text-left'> ".$AdditionalCostDescription.  "</td>";	
													$results .= "<td> ".$AdditionalCostNum." </td>";	
													$results .= "<td> ".$SetupChargeNum." </td>";	
													$results .= "</tr>"; 
												} 
												
											}
											
										}

										$results .= $adds4;
										$results .= $adds5;  


									endif;	

							}	 
							




							
					}else{
						$results .= $this->priceNotAvailable;
					}

				}else{
					 
					$results .= $this->priceNotAvailable;
				} // end If pricing exists

			}

			// SKinned site 
			if($loginUser == 0  ||  $skinnedSite == 1){
				 
				 
				$Markup1 = $Currency['customArray']['themeArray'][0]->Q1Markup;
				$Markup2 = $Currency['customArray']['themeArray'][0]->Q2Markup;
				$Markup3 = $Currency['customArray']['themeArray'][0]->Q3Markup;
				$Markup4 = $Currency['customArray']['themeArray'][0]->Q4Markup;
				$Markup5 = $Currency['customArray']['themeArray'][0]->Q5Markup;
				$Markup6 = $Currency['customArray']['themeArray'][0]->Q6Markup;
				$custMarkupBranding = $Currency['customArray']['themeArray'][0]->BrandingPriceMarkup;
				$custMarkupSetup = $Currency['customArray']['themeArray'][0]->SetupMarkup;


				if($resultspricing){  // If pricing exists

					if($resultspricing[0]->Price1){ 

								//Start
							$results = "<strong>Pricing - " .$Currency['MyCurrency']. "  </strong>";
							$results .= "<table class='table text-center table-bordered small-table-font table-sm table-striped' border='0' cellspacing='0' cellpadding='0'>
								<thead class='thead-dark'>
									<tr>
										<th colspan='6' >".strtoupper($resultspricing[0]->PrimaryPriceDes)."</th> 
									</tr>
								</thead>";
							$results .= "<tbody>";

							foreach($resultspricing as $row){

										$Quantity1 = '';
										$Quantity2 = '';
										$Quantity3 = '';
										$Quantity4 = '';
										$Quantity5 = '';
										$Quantity6 = '';

										if($row->Price1 > 0){
											$Quantity1 = $row->Quantity1;
											$Price1 =  $row->Price1;
										}
										if($row->Price2 > 0){
											$Quantity2 = $row->Quantity2;
											$Price2 =  $row->Price2;
										}
										if($row->Price3 > 0){
											$Quantity3 = $row->Quantity3;
											$Price3 =  $row->Price3;
										}
										if($row->Price4 > 0){
											$Quantity4 = $row->Quantity4;
											$Price4 =  $row->Price4;
										}
										if($row->Price5 > 0){
											$Quantity5 = $row->Quantity5;
											$Price5 =  $row->Price5;
										}
										if($row->Price6 > 0){
											$Quantity6 = $row->Quantity6;
											$Price6 =  $row->Price6;
										}

										$results .= "<tr>";
										$results .= "<td width='15%'> ".$Quantity1.  "</td>";
										$results .= "<td width='15%'> ".$Quantity2.  "</td>";
										$results .= "<td width='15%'> ".$Quantity3.  "</td>";
										$results .= "<td width='15%'> ".$Quantity4.  "</td>";
										$results .= "<td width='15%'> ".$Quantity5.  "</td>";
										$results .= "<td width='15%'> ".$Quantity6.  "</td>";
										$results .= "</tr>";
										$results .= "<tr>";
										for($i=1;$i<7;$i++) {  
											$PriceNum = 'Price' . $i;
											$MarkupNum = 'Markup' . $i;

											//$results .=   ${$PriceNum}. " / " .${$MarkupNum} ;
											$skinnedPrice  =  ${$PriceNum}* ((${$MarkupNum} * 0.01)+1); 
											if($skinnedPrice != 0){
												$results .= "<td> $".number_format($skinnedPrice,2, '.', ' ').  "</td>";
											}else{
												$results .= "<td> &nbsp; </td>";
											}
											
											/* $pricingLocal['AdditionalCost'.$i] = $pricingLocal['AdditionalCost'.$i] * (($custMarkupBranding * 0.01)+1); 
											if($pricingLocal['SetupCharge'.$i] !=="0") {
												$custSetupRounder = $pricingLocal['SetupCharge'.$i] * (($custMarkupSetup * 0.01)+1);
												$pricingLocal['SetupCharge'.$i] = round(($custSetupRounder+5/2)/5)*5;
											}  */
										}
										$results .= "</tr>";
							}

							$results .= "</tbody>";
							$results .= "</table>";




							/*********** SKINNED SITE ADDITIONAL COST ******************* */
							 

							if(count($reqAdditionalOptionsArrays) > 0){

								// IF converted = 1

								/********* Converted ***************/
								$reqAdditionalCount = count($reqAdditionalOptionsArrays); 

								$results .= $adds1;
								$results .= $adds2; 
								$results .= $adds3; 

								foreach($reqAdditionalOptionsArrays as $rowUpgradeAdds){

									if($rowUpgradeAdds->costDescription){
										$results .= "<tr>";
										$AdditionalCostDescription = $rowUpgradeAdds->costDescription;


										$additionalCostSkinned = $rowUpgradeAdds->{$Currency['MyCurrency']."UnitPrice"} * (($custMarkupBranding * 0.01)+1); 
										$AdditionalCostNum = "$" .number_format($additionalCostSkinned,2, '.', ' '); 
 

										$custSetupRounder = $rowUpgradeAdds->{$Currency['MyCurrency']."OrderPrice"} * (($custMarkupSetup * 0.01)+1);
										$SetupChargeRound  = round(($custSetupRounder+5/2)/5)*5;
										
										$SetupChargeNum = "$".number_format($SetupChargeRound,2, '.', ' ');  

										if($rowUpgradeAdds->{$Currency['MyCurrency']."UnitPrice"} == 0){
											$AdditionalCostNum = '';
										}
										if($rowUpgradeAdds->{$Currency['MyCurrency']."OrderPrice"} == 0){
											$SetupChargeNum = '';
										}

										$results .= "<td class='text-left'> ".$AdditionalCostDescription;  
										if($rowUpgradeAdds->brandingArea){
											$results .= "<small  style='line-height:1.2; display:block'><i> ".$rowUpgradeAdds->brandingArea." </i></small> ";
										} 
										$results .= "</td>";
										$results .= "<td> ".$AdditionalCostNum." </td>";	
										$results .= "<td> ".$SetupChargeNum." </td>";	
										$results .= "</tr>"; 
									} 

								}

								$results .= $adds4;
								$results .= $adds5; 

								/* COnverted  **************************/
		
							}else{

									// IF converted = 0 
									//Skinned Additional Costs
									if($resultspricing[0]->AdditionalCostDesc1):

										$results .= $adds1;
										$results .= $adds2; 
										$results .= $adds3; 

										foreach($resultspricing as $row2){
											
											$AdditionalCostDescription = '';
										
											for($i=1;$i<13;$i++) {  
												
												//Additional Cost
												$AdditionalCostDesc = 'AdditionalCostDesc' . $i;
												$AdditionalCost = 'AdditionalCost' . $i;
												$SetupCharge = 'SetupCharge' . $i;
												if($row2->$AdditionalCostDesc){
													$results .= "<tr>";
													$AdditionalCostDescription = $row2->$AdditionalCostDesc;

													$additionalCostSkinned = $row2->$AdditionalCost * (($custMarkupBranding * 0.01)+1); 
													$AdditionalCostNum = "$" .number_format($additionalCostSkinned,2, '.', ' '); 

													

													$custSetupRounder = $row2->$SetupCharge * (($custMarkupSetup * 0.01)+1);
													$SetupChargeRound  = round(($custSetupRounder+5/2)/5)*5;
													
													$SetupChargeNum = "$".number_format($SetupChargeRound,2, '.', ' ');  

													if($row2->$AdditionalCost == 0){
														$AdditionalCostNum = '';
													}
													if($row2->$SetupCharge == 0){
														$SetupChargeNum = '';
													}

													$results .= "<td class='text-left'> ".$AdditionalCostDescription.  "</td>";	
													$results .= "<td> ".$AdditionalCostNum." </td>";	
													$results .= "<td> ".$SetupChargeNum." </td>";	
													$results .= "</tr>"; 
												} 
												
											}
											
										}

										$results .= $adds4;
										$results .= $adds5; 
										
									endif;
							


							}

							/**********SKINNED SITE ADDDITIONAL COST****************************** */
					

									


							//Skinned INFORMATION
							$results .= "<table class='table text-center table-bordered small-table-font table-sm table-striped' border='0' cellspacing='0' cellpadding='0'>
								<thead class='thead-dark'>
									<tr>
										<th  > INFORMATION </th> 
									</tr>
								</thead>";
							$results .= "<tbody>";
							$results .= "<tr>";

							$PricingInformation1 = $Currency['customArray']['themeArray'][0]->PricingInformation1;
							$PricingInformation2 = $Currency['customArray']['themeArray'][0]->PricingInformation2;
							$PricingInformation3 = $Currency['customArray']['themeArray'][0]->PricingInformation3;
							$PricingInformation4 = $Currency['customArray']['themeArray'][0]->PricingInformation4;
							$PricingInformation5 = $Currency['customArray']['themeArray'][0]->PricingInformation5;
							$PricingInformation6 = $Currency['customArray']['themeArray'][0]->PricingInformation6;
							$PricingInformation7 = $Currency['customArray']['themeArray'][0]->PricingInformation7;
							$PricingInformation8 = $Currency['customArray']['themeArray'][0]->PricingInformation8;
							$PricingInformation9 = $Currency['customArray']['themeArray'][0]->PricingInformation9;
							$PricingInformation10 = $Currency['customArray']['themeArray'][0]->PricingInformation10;
							$AdditionalInformation = $Currency['customArray']['themeArray'][0]->AdditionalInformation;

							$AdditionalInformation = $Currency['customArray']['themeArray'][0]->AdditionalInformation;
							$allowMOQ = $Currency['customArray']['themeArray'][0]->allowMOQ;
							$MOQSurcharge = $Currency['customArray']['themeArray'][0]->MOQSurcharge;

							$results .= "<td class='text-left padding'>";

							if ($PricingInformation1 != "") {
								$results .= $PricingInformation1."<br />";
							} else {
								if ($AdditionalInformation != "") {
									$results .= $AdditionalInformation."<br />";
								}
							}
							if ($allowMOQ == 1) { 
								$results .= "Less than minimum quantities are available for a $".$MOQSurcharge." surcharge on ex-stock orders.<br />"; 
							} else { 
								$results .= "Less than minimum quantities are not available for this item.<br />";
							}
							if ($PricingInformation1 == "") { 
								$results .= "Prices are in ".$Currency['MyCurrency']." and exclude GST.<br />";
								$results .= "Freight is free of charge to one location in ".$Currency['MyPlace'].".<br />Split delivery is available at $".$this->splitDevCharge." per location.";
							} else {
								if ($PricingInformation2 != "") {
									$results .= $PricingInformation2."<br />";
								}
								if ($PricingInformation3 != "") {
									$results .= $PricingInformation3."<br />";
								}
								if ($PricingInformation4 != "") {
									$results .= $PricingInformation4."<br />";
								}
								if ($PricingInformation5 != "") {
									$results .= $PricingInformation5."<br />";
								}
								if ($PricingInformation6 != "") {
									$results .= $PricingInformation6."<br />";
								}
								if ($PricingInformation7 != "") {
									$results .= $PricingInformation7."<br />";
								}
								if ($PricingInformation8 != "") {
									$results .= $PricingInformation8."<br />";
								}
								if ($PricingInformation9 != "") {
									$results .= $PricingInformation9."<br />";
								}
								if ($PricingInformation10 != "") {
									$results .= $PricingInformation10."<br />";
								}
							} 
							$results .= "</td>";	
							$results .= "</tr>"; 
							$results .= "</tbody>";
							$results .= "</table>";
					}else{
						$results .= $this->priceNotAvailable;
					}

				}else{
					$results .= $this->priceNotAvailable;
				} // end If pricing exists


			}

		}

		return  $results;

	}

	/* product Stock available Future date */

	public function productStockAvailableFutureDate($DueDate){
				$nextShipment = "";
				$CleanedDate = rtrim($DueDate);
			 	$CleanedDate2 = explode(" ", $CleanedDate);
				$CleanedDate3 = explode("-", $CleanedDate2[0]);
				$timestamp = mktime(0, 0, 0, $CleanedDate3[1], 1, 2005);
				$CleanedDate3[1] = date("M", $timestamp);
				$curYear = date('Y'); 
				if($CleanedDate3[2] < 10) {
					$CleanedDate3[2] = "Mid";
				} else {
				
					if($CleanedDate3[2] <= 20 && $CleanedDate3[2] >= 10 ) {
						$CleanedDate3[2] = "Late";
					} else { 
						$extractMonth = date("m", $timestamp); 
						$extractMonth = $extractMonth + 1; 
						$monthName = date("M", mktime(null, null, null, $extractMonth)); 
						$CleanedDate3[2] = "Early";
						//$addMonth =  strtotime( "+1 month", strtotime( $CleanedDate) );
						$CleanedDate3[1] = $monthName;
					}
				}
				if($curYear == $CleanedDate3[0]) {
					$nextShipment = $CleanedDate3[2]." ".$CleanedDate3[1];
				} else {

					$nextShipment = $CleanedDate3[2]." ".$CleanedDate3[1]." ".$CleanedDate3[0];
				}

				return $nextShipment;
										
	} 

	public function productStockAvailableFutureDateLogin($DueDate){
		 	$nextShipment = "";
			$CleanedDate = rtrim($DueDate);
			$CleanedDate2 = explode(" ", $CleanedDate);
			$CleanedDate3 = explode("-", $CleanedDate2[0]); 
										 
										 
			$monthNum  = $CleanedDate3[1];
			$dayNum  = $CleanedDate3[2];
			$monthName = $this->getMOnth($monthNum);

			if($dayNum <= 10){
				$nextShipment = "Mid ".$monthName;
			}
			if($dayNum >= 11 && $dayNum <= 20 ){
				$nextShipment = "Late ".$monthName;
			} 
			if($dayNum >= 21 && $dayNum <= 31 ){
				$monthNumTemp = $monthNum + 1;
				$monthName = $this->getMOnth($monthNumTemp); 
				$nextShipment = "Early ". $monthName;
			}	
			return $nextShipment;
	}

	/* General function to get the Currency and availcountry using the $customID */
	function getMyCurrency($skinned){
		if($skinned){ 
			  $customArray = $this->general_model->checkID($skinned); 
			  $checkAvailCountry = $this->checkip_model->checkAvailCountry($this->siteLogcheck, $customArray); 
			  $availAccess = $this->checkip_model->availCheckAccess($checkAvailCountry);  

			  $getCountryCurrencies = $this->general_model->getCurrencyData(); 

			  if($checkAvailCountry == "availNZ"){
				  	$currency = $getCountryCurrencies[0]->currencyName;
				  	$place = $getCountryCurrencies[0]->currencyCountry;
			  }
			  if($checkAvailCountry == "availAU"){
					$currency = $getCountryCurrencies[1]->currencyName;
					$place = $getCountryCurrencies[1]->currencyCountry;
			   }
			 if($checkAvailCountry == "availSG"){
				$currency = $getCountryCurrencies[2]->currencyName;
				$place = $getCountryCurrencies[2]->currencyCountry;
			 }
			 if($checkAvailCountry == "availMY"){
				$currency = $getCountryCurrencies[3]->currencyName;
				$place = $getCountryCurrencies[3]->currencyCountry;
		     }
		}
		 
		//print_r($skinned. "Heey " .$currency. " " .$place);
		return array('MyCurrency'=> $currency, 'MyPlace'=>$place, 'MyAccess'=>$availAccess, 'customArray' => $customArray);
		 
	}

	function getPMSTable($code, $name){

		$results['Title'] = $this->general_model->cleanString($name);

		 
		$pmsResults = $this->db->query("SELECT * FROM productsStock WHERE Code LIKE ".$code." AND PmsCode IS NOT NULL AND PmsCode !='' AND (Quantity > 0 OR FutureAvailableQty  > 0)  ORDER BY SortCode");
		$results['pmsTables'] = $pmsResults->result();

		return $results;
	}


	function lastUpdated(){
			date_default_timezone_set('NZ'); 
            $rowXX =  $this->getStockDateTimeValue();
            
            $date1 = strtotime($rowXX[0]->DateTimeValue);
            $fixedDate1 = date("Y-m-d H:i",$date1);
            
            $date2 = time();
            $fixedDate2 = date("Y-m-d H:i",$date2);
            
            
            
            $diff = abs($date2 - $date1); 
            
            $years   = floor($diff / (365*60*60*24)); 
            
            $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
            
            $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            
            $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 
            
            $minutes  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
            
             
            if($hours > 0) {
                if($hours > 1) {
                    $textTime = $textTime.$hours." hours ";
                } else {
                    $textTime = $textTime.$hours." hour ";
                }
            } else {
                if($minutes < 55) {
                    $textTime = 5 * ceil($minutes / 5)." minutes";
                } else {
                    $textTime = "55 minutes";
                }
            }
            
            return "Last Updated ".$fixedDate1." (".$textTime." ago)";
	}
	
	function getMOnth($monthNum){ 
		$dateObj   = DateTime::createFromFormat('!m', $monthNum);
		$monthNames = $dateObj->format('F'); 
		return $monthNames;
	}

	function checkifPeriod($text){
		$period = ".";
		 

		if (strpos($text, ".")  !== false) {
			$period = "";
		}
		return $period;
	}


	function checkTotalRoundUp($tempTotal){

		if($tempTotal <= 100){
			//echo "Less or equal 100 <br />";
			$valRound =  $tempTotal;
		}
		if($tempTotal >= 100 && $tempTotal <= 1000){
			//echo "Greater 100/Less than 1k  <br />";
			$valRound =  $this->roundUp($tempTotal, 10);
		}
		if($tempTotal >= 1000 && $tempTotal <= 5000){
			//echo "Greater 1000/Less than 5k  <br />";
			$valRound =  $this->roundUp($tempTotal, 50);
		} 
		if($tempTotal >= 5000){
			//echo "Greater than 5k  <br />";
			$valRound =  $this->roundUp($tempTotal, 100);
		} 
		return $valRound;  
	}
	function roundUp($totalFormat, $num){
		$roundTotal = floor($totalFormat / $num) * $num;
		return $roundTotal;
	}

	public function getMessageNonHitPromo(){
		$msgHitNone = 'Please contact your Account Manager for stock availability information.';
		return $msgHitNone;
	} 

	public function underlineBrand($brandName, $varArray = null){

			$isIndent = null;
			$IsIndentExpress = null;	
			 if($varArray){
				 $isIndent = $varArray['IsIndent'];
				 $IsIndentExpress = $varArray['IsIndentExpress'];
			 }

			$getBranding = $this->general_model->getBrandingMenu();
			$countB = count($getBranding)-1;
		  
			if($brandName){

				$result = $brandName; 

				for($x = 0; $x <= $countB; $x++){
					if($getBranding[$x]['topMenu'] == 1){
						$arrayBrand[] = $getBranding[$x]['title'];
					}  

					if($getBranding[$x]['title'] == 'Debossing XL'){
						$arrayBrand[] = $getBranding[$x]['title'];
					} 
					if($getBranding[$x]['title'] == 'Thermo Debossing XL'){
						$arrayBrand[] = $getBranding[$x]['title'];
					} 
					if($getBranding[$x]['title'] == 'Thermo Debossing'){
						$arrayBrand[] = $getBranding[$x]['title'];
					}  
				} 
				$RotaryScreenPrint = "Rotary Screen Print";
				if($brandName == "Screen Print"){
					$brandName = $RotaryScreenPrint;
				}
				if (in_array($brandName, $arrayBrand)) 
				{ 
					if($brandName == $RotaryScreenPrint){
						$brandName = "Screen Print";
					}
					$result = "<u>".$brandName."</u>";
				}else{
					
				} 
				if($brandName == "Resin Coated Finish"){
					$brandName = "Resin Coated Finish";
					$temp = "  ";
					if($IsIndentExpress || $isIndent){
						$temp = "";
					}
					$result = "<u>".$brandName."</u>".$temp;
				}

			}else{
				$result = "";
			}
			

			return $result;
	}

	public function make_list($items) {
		$count = count($items);
	
		if ($count === 0) {
			return '';
		}
	
		if ($count === 1) {
			return $items[0];
		}
	
		return implode(', ', array_slice($items, 0, -1)) . ' or ' . end($items);
	}

	public function getItemDescription($prim, $code, $field){
		$query = $this->db->query("SELECT  ".$field."  FROM ".$this->tableProducts." WHERE Prim = '".$prim."' AND Code ='".$code."'   ");
		$results = $query->result(); 
		return $results;	
	}
 
	
	 
}
