<?php
 
class Category_Model extends CI_Model {

	public function __construct(){ 
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->tableAdditionalOptions = "additionalOptions";
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->tableAdditionalOptions = "additionalOptions";
		}

	 
	}

	public function getCategoryName($item){
		//return $item;
		$results = array();
		$query = $this->db->query("SELECT * FROM categoriesCurrent WHERE CategoryNum LIKE '".$item."' ");
		$results['categoryPage'] = $query->result();

		$itemArray = explode("-", $item);
		if($itemArray[1] != 0){
			$mainCategory = $itemArray[0]. "-0";
			$queryMain = $this->db->query("SELECT * FROM categoriesCurrent WHERE CategoryNum LIKE '".$mainCategory."' ");
			$resultsMain = $queryMain->result();
			$results['mainCategory'] = array('mainCategoryName'=> $resultsMain[0]->CategoryName, 'mainCategoryNumber'=> $resultsMain[0]->CategoryNum );
		}

		if($item == "0-0"){  
			 $arrayObj = array("CategoryNum" => "0-0", "CategoryName" => "New Products" );
			 $results['categoryPage']  = array( 0=> (object) $arrayObj );
		}

		/* NEW SUB CATEGORIES */
		 //Apparel
		 if($item  == "0-4"){  
			$arrayObj = array("CategoryNum" => "0-4", "CategoryName" => "Apparel" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 }
		 //Bags
		 if($item == "0-10"){
			$arrayObj = array("CategoryNum" => "0-10", "CategoryName" => "Bags" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Business
		 if($item == "0-7"){
			$arrayObj = array("CategoryNum" => "0-7", "CategoryName" => "Business" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Drinkware
		 if($item == "0-2"){
			$arrayObj = array("CategoryNum" => "0-2", "CategoryName" => "Drinkware" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 
		  //HEadwear
		  if($item == "0-3"){
			$arrayObj = array("CategoryNum" => "0-3", "CategoryName" => "Headwear" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Key rings
		 if($item == "0-5"){
			$arrayObj = array("CategoryNum" => "0-5", "CategoryName" => "Key Rings" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Leisure
		 if($item == "0-13"){
			$arrayObj = array("CategoryNum" => "0-13", "CategoryName" => "Leisure" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 }  
	 

		 //Pens
		 if($item == "0-1"){
			$arrayObj = array("CategoryNum" => "0-1", "CategoryName" => "Pens" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Personal
		 if($item == "0-11"){
			$arrayObj = array("CategoryNum" => "0-11", "CategoryName" => "Personal" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Print
		 if($item == "0-6"){
			$arrayObj = array("CategoryNum" => "0-6", "CategoryName" => "Print" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Promotion
		 if($item == "0-8"){
			$arrayObj = array("CategoryNum" => "0-8", "CategoryName" => "Promotion" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Technology
		 if($item == "0-9"){
			$arrayObj = array("CategoryNum" => "0-9", "CategoryName" => "Technology" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 //Tools
		 if($item == "0-12"){
			$arrayObj = array("CategoryNum" => "0-12", "CategoryName" => "Tools" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
			$results['mainCategory'] = array('mainCategoryName'=> "New", 'mainCategoryNumber'=> "0-0" );
		 } 
		 

		 /* NEW SUB CATEGORIES */

		if($item == "products"){  
			$arrayObj = array("CategoryNum" => "555-0", "CategoryName" => "Search Products" );
			$results['categoryPage']  = array( 0=> (object) $arrayObj );
	   }

		//return $query->result();
		return $results;
	}

	function getCategoryProducts($item, $siteLogcheck, $checkAvailCountry, $customArray, $flag=null, $rowperpage=null, $parameters=null){
			/*echo "<pre>";
		 	 print_r($customArray['themeArray'][0]->Q1Markup);
			 echo "</pre>"; */
			 //echo " == ".$flag. " == ".$rowperpage. " == ";
			  
			 
			$availQuery = " ";
			if($siteLogcheck['userDatas'][0]->Currency != "" && $siteLogcheck['loggedIn'] == 1 && count($customArray['customerAccount']) == 0  ) {
				$currencySort = $siteLogcheck['userDatas'][0]->Currency;	
				
				if($currencySort == "NZD"){
					$availQuery = " AND availNZ = 1 ";
				}
				if($currencySort == "AUD"){
					$availQuery = " AND availAU  = 1  ";
				}
				if($currencySort == "SGD"){
					$availQuery = " AND availSG  = 1  ";
				}
				if($currencySort == "MYR"){
					$availQuery = " AND availMY  = 1  ";
				}
				
				if($siteLogcheck['userDatas'][0]->multiCurrency == 1){
					//$availQuery = "  ";
				}
				 
				
			} else {
				if($checkAvailCountry == "availNZ") {	
					$currencySort = "NZD";
				} 
				if($checkAvailCountry == "availAU") {
					$currencySort = "AUD";
				} 
				if($checkAvailCountry == "availSG") {
					$currencySort = "SGD";
				} 
				if($checkAvailCountry == "availMY") {
					$currencySort = "MYR";
				} 

				if($currencySort == "NZD"){
					$availQuery = " AND  availNZ = 1 "; 
				}
				if($currencySort == "AUD"){
					$availQuery = " AND availAU  = 1 ";
				}
				if($currencySort == "SGD"){
					$availQuery = " AND availSG  = 1 ";
				}
				if($currencySort == "MYR"){
					$availQuery = " AND availMY  = 1 ";
				}
				 
			}

			 

			//Get category number and subtr
			//Changes when ALL category
			 if($customArray['category'] == "all" || $parameters->categoriesAll == "all" ){
				$valueNew =  $item;
			 }else{
				$valueN  = substr($item, 0, -2);
				$valueNew = $valueN; 
			 }
			
			 $colour = null;
			 $Branding = null;
			 $stockNumber = null;
			 $keywordSearch = null;
			 $priceSort = null;
			 $queryColour = "";
			 $queryBrand = "";
			 $queryKeyword = "";
			 $queryPrice = "";
			 $queryStock = "";
			 $sortAlphabet = "";
			 $custMarkups1 = 0;
			 $custMarkups2 = 0;
			 $custMarkups3 = 0;
			 $custMarkups4 = 0;
			 $custMarkups5 = 0;
			 $custMarkups6 = 0;
			 $custMarkupBranding = 0;
			 $activateGroupBranding = 0;
			

			 /*************** add additionalOptions table here **************/
			 $brandingQueryDefault = " SELECT PricingType, ProductCode, costDescription, brandingMethod, brandingArea, orderRow, ".$currencySort."UnitPrice, ".$currencySort."OrderPrice  FROM ".$this->tableAdditionalOptions." ";
			if($parameters->Branding != null || $parameters->Branding != ""){

				/******* IF IT HAS BRANDING ON SEARCH remove orderRow = 1 ********* */
				$Branding = $parameters->Branding; 	
				if($Branding == 'All Full Colour'){
					$BrandingQuery = " ( ".$brandingQueryDefault."   GROUP BY ".$this->tableAdditionalOptions.".ProductCode) ";
				}else{ 
					//$BrandingQuery = " ( ".$brandingQueryDefault." ) "; 
					$BrandingQuery = " ( ".$brandingQueryDefault."     ) "; 
				} 
				/******* IF IT HAS BRANDING ON SEARCH   orderRow = 1 ********* */

			}else{  

				/******* IF IT HAS NO BRANDING add the orderRow = 1 ********* */
				$BrandingQuery = " ( ".$brandingQueryDefault."  WHERE  orderRow = '1' AND  (PricingType = 'Stock' OR PricingType = 'Indent - Air')     GROUP BY ".$this->tableAdditionalOptions.".ProductCode) ";

			} 

			/******* 
			 * Main query and join table 
			 * 
			 * ***********************/
			$queryStart = "SELECT * FROM ".$this->tableProducts."  LEFT JOIN  ".$BrandingQuery."  ".$this->tableAdditionalOptions."   ON ".$this->tableProducts.".Code = ".$this->tableAdditionalOptions.".ProductCode  LEFT JOIN ".$this->tablePricing." ON ".$this->tablePricing.".Coode = ".$this->tableProducts.".Code AND (".$this->tablePricing.".Currency = '".$currencySort."') AND (".$this->tablePricing.".PriceOrder = '1') "; 
			
			
			 

			if(count($customArray['customerAccount']) > 0){
				$custMarkups1 = $customArray['themeArray'][0]->Q1Markup;
				$custMarkups2 = $customArray['themeArray'][0]->Q2Markup;
				$custMarkups3 = $customArray['themeArray'][0]->Q3Markup;
				$custMarkups4 = $customArray['themeArray'][0]->Q4Markup;
				$custMarkups5 = $customArray['themeArray'][0]->Q5Markup;
				$custMarkups6 = $customArray['themeArray'][0]->Q6Markup;
				$custMarkupBranding  = $customArray['themeArray'][0]->BrandingPriceMarkup;
			}

			

			if($parameters->keyword != null || $parameters->keyword != ""){
				$keywordSearch = $parameters->keyword; 	
			} 
			 
			if($parameters->Colours != null || $parameters->Colours != ""){
				if ($parameters->Colours == "Natural Coloured"){
					$parameters->Colours = "Natural";
				}
				if ($parameters->Colours == "Clear and Transluscent"){
					$parameters->Colours = "Clear";
				}
				if ($parameters->Colours == "Bright Green"){
					$parameters->Colours = "Bgreen";
				}
				if ($parameters->Colours == "Light Blue"){
					$parameters->Colours = "Lblue";
				}
				$colour = strtolower($parameters->Colours); 	
				 
			} 

			if($parameters->stockNumber != null || $parameters->stockNumber != ""){
				$stockNumber =  $parameters->stockNumber; 	
			} 

			//Create bridge here for highest and low price
			if($parameters->highPrice > 0 && ($parameters->lowPrice == null || $parameters->lowPrice == 0)  ){
				$parameters->lowPrice = 0.1; 
			}

			//Reset if NEw Categories and Subcategories
			$newSubCat  = substr($item, 0, -2); 
			//if($item == "0-0" ||  $newSubCat == "0" ){ 
				if($parameters->lowPrice == 0.1 && $parameters->highPrice == 200 ){
					$parameters->lowPrice = 0;
					$parameters->highPrice = 0; 
				}
				 // echo " == ". $parameters->lowPrice. " / ". $parameters->highPrice. " == "; ||  $customArray['category'] == "all"  || $parameters->categoriesAll == "all"
			//}

			/******* 
			 * Price Range 
			 * 
			 * ***********************/

			if($parameters->lowPrice != null || $parameters->lowPrice != 0){
				$lowPrice = $parameters->lowPrice; 	 
			 
				$price1 = "if(".$this->tablePricing.".Price1 !='0',  (".$this->tablePricing.".Price1 * ((".$custMarkups1." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), 0)";
				$price2 = "if(".$this->tablePricing.".Price2 !='0',  (".$this->tablePricing.".Price2 * ((".$custMarkups2." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price1.")";
				$price3 = "if(".$this->tablePricing.".Price3 !='0',  (".$this->tablePricing.".Price3 * ((".$custMarkups3." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price2.")";
				$price4 = "if(".$this->tablePricing.".Price4 !='0',  (".$this->tablePricing.".Price4 * ((".$custMarkups4." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price3.")";
				$price5 = "if(".$this->tablePricing.".Price5 !='0',  (".$this->tablePricing.".Price5 * ((".$custMarkups5." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price4.")";
				$price6 = "if(".$this->tablePricing.".Price6 !='0',  (".$this->tablePricing.".Price6 * ((".$custMarkups6." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price5.")";
		
				$priceDefault1 = "if(".$this->tablePricing.".Price1 !='0',  (".$this->tablePricing.".Price1 * ((".$custMarkups1." * 0.01)+1)), 0 )";
				$priceDefault2 = "if(".$this->tablePricing.".Price2 !='0',  (".$this->tablePricing.".Price2 * ((".$custMarkups2." * 0.01)+1)), ".$priceDefault1.")";
				$priceDefault3 = "if(".$this->tablePricing.".Price3 !='0',  (".$this->tablePricing.".Price3 * ((".$custMarkups3." * 0.01)+1)), ".$priceDefault2.")";
				$priceDefault4 = "if(".$this->tablePricing.".Price4 !='0',  (".$this->tablePricing.".Price4 * ((".$custMarkups4." * 0.01)+1)), ".$priceDefault3.")";
				$priceDefault5 = "if(".$this->tablePricing.".Price5 !='0',  (".$this->tablePricing.".Price5 * ((".$custMarkups5." * 0.01)+1)), ".$priceDefault4.")";
				$priceDefault6 = "if(".$this->tablePricing.".Price6 !='0',  (".$this->tablePricing.".Price6 * ((".$custMarkups6." * 0.01)+1)), ".$priceDefault5.")";
		 
				$priceTypeSelect = "if(".$this->tablePricing.".PriceType = 'U', ".$price6.",  ".$priceDefault6." )";
		 
				$queryPrice .= " AND  ( ".$priceTypeSelect."  ) >= ".$lowPrice." ";   

				$activateGroupBranding = 1;
			} 


			if($parameters->highPrice != null || $parameters->highPrice != 0) {

				$priceHigh = $parameters->highPrice; 	 
				 
				$price1 = "if(".$this->tablePricing.".Price1 !='0',  (".$this->tablePricing.".Price1 * ((".$custMarkups1." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), 0)";
				$price2 = "if(".$this->tablePricing.".Price2 !='0',  (".$this->tablePricing.".Price2 * ((".$custMarkups2." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price1.")";
				$price3 = "if(".$this->tablePricing.".Price3 !='0',  (".$this->tablePricing.".Price3 * ((".$custMarkups3." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price2.")";
				$price4 = "if(".$this->tablePricing.".Price4 !='0',  (".$this->tablePricing.".Price4 * ((".$custMarkups4." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price3.")";
				$price5 = "if(".$this->tablePricing.".Price5 !='0',  (".$this->tablePricing.".Price5 * ((".$custMarkups5." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price4.")";
				$price6 = "if(".$this->tablePricing.".Price6 !='0',  (".$this->tablePricing.".Price6 * ((".$custMarkups6." * 0.01)+1))  +  (".$this->tableAdditionalOptions.".".$currencySort."UnitPrice * ((".$custMarkupBranding." * 0.01)+1)), ".$price5.")";
		 
				$priceDefault1 = "if(".$this->tablePricing.".Price1 !='0',  (".$this->tablePricing.".Price1 * ((".$custMarkups1." * 0.01)+1)), 0 )";
				$priceDefault2 = "if(".$this->tablePricing.".Price2 !='0',  (".$this->tablePricing.".Price2 * ((".$custMarkups2." * 0.01)+1)), ".$priceDefault1.")";
				$priceDefault3 = "if(".$this->tablePricing.".Price3 !='0',  (".$this->tablePricing.".Price3 * ((".$custMarkups3." * 0.01)+1)), ".$priceDefault2.")";
				$priceDefault4 = "if(".$this->tablePricing.".Price4 !='0',  (".$this->tablePricing.".Price4 * ((".$custMarkups4." * 0.01)+1)), ".$priceDefault3.")";
				$priceDefault5 = "if(".$this->tablePricing.".Price5 !='0',  (".$this->tablePricing.".Price5 * ((".$custMarkups5." * 0.01)+1)), ".$priceDefault4.")";
				$priceDefault6 = "if(".$this->tablePricing.".Price6 !='0',  (".$this->tablePricing.".Price6 * ((".$custMarkups6." * 0.01)+1)), ".$priceDefault5.")";
		 
				$priceTypeSelect = "if(".$this->tablePricing.".PriceType = 'U', ".$price6.",  ".$priceDefault6." )"; 
				$queryPrice .= " AND  ( ".$priceTypeSelect."  ) <=  ".$priceHigh." ";  
		  
				$activateGroupBranding = 1;
			}
			  
			//Sort Pricing
			if($parameters->priceSort != null || $parameters->priceSort != ""){
				$priceSort =  $parameters->priceSort; 	
			} 



			 

			/******* 
			 * Colours, Stock and Sorting
			 * 
			 * ***********************/

			if($colour != null && $stockNumber == null){  
				 $queryStart .= " LEFT JOIN  segmentStockCode   ON segmentStockCode.FGCode = ".$this->tableProducts.".Code  WHERE ";

			 
			}elseif($stockNumber != null && $colour == null ){ 
				$queryStart .= " LEFT JOIN ( SELECT Code, PartName,  MAX(Quantity) AS Quantity FROM productsStock WHERE SortCode != 0   GROUP BY Code ) stk ON ".$this->tableProducts.".Code = stk.Code WHERE ";
			}elseif($colour != null && $stockNumber != null){
					$queryStart .= " LEFT JOIN  segmentStockCode   ON ".$this->tableProducts.".Code = segmentStockCode.FGCode ";  
					$queryStart .= " LEFT JOIN productsStock ON segmentStockCode.FGCode = productsStock.Code AND  segmentStockCode.StockCode = productsStock.ComponentCode   WHERE "; 
		
			}else{
				$queryStart .= " WHERE ";
			} 



			if($parameters->Colours != null){
				$queryColour  = " AND   segmentStockCode.Colour = '".$colour."'  ";	 
			}   

			/********** 
			 * BRANDING NEW 
			 * *******************/
			 
			if($parameters->Branding != null || $parameters->Branding != ""){  
				
				 
				
				if($activateGroupBranding == 1){
					$groupBy = "  ";
				}else{
					$groupBy = " GROUP BY ".$this->tableAdditionalOptions.".ProductCode ";
				}
				
				if($Branding == 'All Full Colour'){
					$queryBrand =  " AND (Active != 0 ".$availQuery." AND ".$this->tableProducts.".FullColour  = '1'  ) "; 
				}else{

					if($Branding == 'Debossing'){
						
						$queryBrand =  " AND  ".$this->tableAdditionalOptions.".brandingMethod IN('Debossing','Silicone Debossed', 'Debossed', 'Thermo Debossing', 'Thermo Debossing XL') ".$groupBy."    ";
					
					}elseif($Branding == 'Digital Print'  ){ 
						$queryBrand =  " AND  ".$this->tableAdditionalOptions.".brandingMethod IN('Digital Print', 'Silicone Digital Print') ".$groupBy."   ";
						 
					}else{ 
						$queryBrand =  "  AND ".$this->tableAdditionalOptions.".brandingMethod LIKE '%".$Branding."%' ".$groupBy."   ";
					}
					
				} 
			} 

			/********** BRANDING NEW *******************/

			if(($stockNumber !== "") && (!is_null($stockNumber)) && ($stockNumber !== "null")) {
				if($colour != null && $stockNumber != null){  
					$ps = 'productsStock';
				}else{
					$ps = 'stk';
				}
				$queryStock .= " AND   ".$ps.".Quantity  >= ".$stockNumber." ";
		   }		
			 
		   /******* 
			 * Pricing Order
			 * 
			 * ***********************/

		   $pricingQueryAdditional = " (if(".$this->tablePricing.".Price6 !='0.00',".$this->tablePricing.".Price6, if(".$this->tablePricing.".Price5 !='0.00',".$this->tablePricing.".Price5, if(".$this->tablePricing.".Price4 !='0.00',".$this->tablePricing.".Price4, if(".$this->tablePricing.".Price3 !='0.00',".$this->tablePricing.".Price3, if(".$this->tablePricing.".Price2 !='0.00',".$this->tablePricing.".Price2,".$this->tablePricing.".Price1))))) + (if(".$this->tableAdditionalOptions.".".$currencySort."UnitPrice != '0', ".$this->tableAdditionalOptions.".".$currencySort."UnitPrice,  0))  ) ";

		     //NEW PRODUCTS QUERY
			if($item == "0-0"){
					$sortAlphabet = " releaseDate DESC, ";
					if($priceSort == "highfirst" || $priceSort == "lowfirst"){
						$sortAlphabet = "   ";
					}  
			}


		    if($priceSort == "atoz" || $priceSort == "ztoa" || $priceSort == "releasednew" || $priceSort == "releasedold"){
				 if($priceSort == "atoz"){
						$sortAlphabet = " Name ASC, ";
				 }
				 if($priceSort == "ztoa"){
						$sortAlphabet = " Name DESC, ";
					 
				}  

				if($priceSort == "releasednew"){
					$pricingQueryAdditional = "";
					$sortAlphabet = " releaseDate DESC ";
				} 
				if($priceSort == "releasedold"){
					$pricingQueryAdditional = "";
					$sortAlphabet = " releaseDate ASC ";
				}  
				
			}
			 
			 
			 $queryData = " ORDER BY  ".$sortAlphabet."  ".$pricingQueryAdditional;   
		   
		    //Sort by Name - $queryData = " ORDER BY Name ASC, 

			 
			//NEW PRODUCTS	 
		   if($item == "0-0"){  // Check if new items category
			  
				$queryMid = " Status = 'N' ".$availQuery." AND Active != 0 ";  
 
				$queryData = " ORDER BY ".$sortAlphabet." ".$pricingQueryAdditional;     

			 	
			
			}elseif($item == "products"){

				/* added last part - SHould not display the 200- */ 
				$queryMid = " (Active != 0 ".$availQuery."    AND Category1  IS NOT NULL    OR Active != 0 ".$availQuery." AND Category2   IS NOT NULL   OR  Active != 0 ".$availQuery." AND Category3   IS NOT NULL  OR  Active != 0 ".$availQuery." AND Category4  IS NOT NULL  OR Active != 0 ".$availQuery." AND Category5  IS NOT NULL  OR Active != 0 ".$availQuery." AND Category6  IS NOT NULL  ) AND Category1  NOT LIKE '200-%' "; 
				
				if($parameters->keyword != null || $parameters->keyword != ""){
					 //$queryKeyword =  " AND (".$this->tableProducts.".Keywords LIKE '%".$keywordSearch."%' ) "; 
					 $queryKeyword =  " AND (".$this->tableProducts.".Code LIKE '%".$keywordSearch."%' OR ".$this->tableProducts.".Name LIKE '%".$keywordSearch."%' OR ".$this->tableProducts.".Keywords LIKE '%".$keywordSearch."%'  ) "; 
				}
			
			}else{
				  
				//Changes when ALL category
				 if($customArray['category'] == "all"  || $parameters->categoriesAll == "all"){

				 
						 $queryMid = " (Active != 0 ".$availQuery." AND Category1  LIKE '".$valueNew."' OR Active != 0 ".$availQuery." AND Category2  LIKE '".$valueNew."' OR  Active != 0 ".$availQuery." AND Category3  LIKE '".$valueNew."' OR  Active != 0 ".$availQuery." AND Category4 LIKE '".$valueNew."' OR Active != 0 ".$availQuery." AND Category5  LIKE '".$valueNew."' OR Active != 0 ".$availQuery." AND Category6  LIKE '".$valueNew."') "; 
						//$queryMid = " '".$valueNew."' IN(Category1, Category2, Category3, Category4, Category5, Category6) ".$availQuery." AND Active != 0";
				 
						if($item == "0-4"){ 
							$valueNew = "14"; 
							$midYes = 1; 
						 }
						 //Bags
						 if($item == "0-10"){
							$valueNew = "1";
							$midYes = 1; 
						 } 
						 //Business
						 if($item == "0-7"){
							$valueNew = "3";
							$midYes = 1; 
						 } 
						 //Drinkware
						 if($item == "0-2"){
							$valueNew = "4";
							$midYes = 1; 
						 } 
						  //HEadwear
						  if($item == "0-3"){
							$valueNew= "9";
							$midYes = 1; 
						 } 
						 //Key rings
						 if($item == "0-5"){
							$valueNew = "6";
							$midYes = 1; 
						 } 
						 //Leisure
						 if($item == "0-13"){
							$valueNew = "10";
							$midYes = 1; 
						 }  
						 //Pens
						 if($item == "0-1"){
							$valueNew = "13";
							$midYes = 1; 
						 } 
						 //Personal
						 if($item == "0-11"){
							$valueNew = "8";
							$midYes = 1; 
						 } 
						 //Print
						 if($item == "0-6"){
							$valueNew = "7";
							$midYes = 1; 
						 } 
						 //Promotion
						 if($item == "0-8"){
							$valueNew = "2";
							$midYes = 1; 
						 } 
						 //Technology
						 if($item == "0-9"){
							$valueNew = "12";
							$midYes = 1; 
						 } 
						 //Tools
						 if($item == "0-12"){
							$valueNew = "11";
							$midYes = 1; 
						 } 
		
						 //Query if exists
						if($midYes == 1){  
							 
							      
							$queryMid = " (Status = 'N' AND Active != 0 ".$availQuery." AND Category1  LIKE '".$valueNew."-%' OR Status = 'N' AND  Active != 0 ".$availQuery." AND Category2  LIKE '".$valueNew."-%' OR  Status = 'N' AND Active != 0 ".$availQuery." AND Category3  LIKE '".$valueNew."-%' OR  Status = 'N' AND Active != 0 ".$availQuery." AND Category4 LIKE '".$valueNew."-%' OR Status = 'N' AND Active != 0 ".$availQuery." AND Category5  LIKE '".$valueNew."-%' OR Status = 'N' AND Active != 0 ".$availQuery." AND Category6  LIKE '".$valueNew."-%') "; 
						}
					
				}else{
					 
					 	$queryMid = " (Active != 0 ".$availQuery." AND Category1  LIKE '".$valueNew."-%' OR Active != 0 ".$availQuery." AND Category2  LIKE '".$valueNew."-%' OR  Active != 0 ".$availQuery." AND Category3  LIKE '".$valueNew."-%' OR  Active != 0 ".$availQuery." AND Category4 LIKE '".$valueNew."-%' OR Active != 0 ".$availQuery." AND Category5  LIKE '".$valueNew."-%' OR Active != 0 ".$availQuery." AND Category6  LIKE '".$valueNew."-%') "; 
				 }
			
			}  
		  
			/******* 
			 * Parameters WHERE clause 
			 * 
			 * ***********************/ 
			$queryMidFinal = $queryMid.$queryKeyword.$queryColour.$queryBrand.$queryPrice.$queryStock;

			/******************** DEBUG ********************/
			$debug = "";
			if($queryMid){
				$debug .= " queryMid = YES / ";
			}
			if($queryKeyword){
				$debug .= " queryKeyword = YES / ";
			}
			if($queryColour){
				$debug .= " queryColour = YES / ";
			}
			 
			if($queryBrand){
				$debug .= " queryBrand = YES / ";
			}
			if($queryPrice){
				$debug .= " queryPrice = YES / ";
			}
			if($queryStock){
				$debug .= " queryStock = YES / ";
			}
			 /******************** DEBUG ********************/
			
			//Default to show 
			 
			if($flag==null){
				$flag = 0;
			}
			if($rowperpage == null){
				$rowperpage = 0;
			}
			 
			/******* 
			 * Limit
			 * 
			 * ***********************/
			$offsetLimit =" limit ".$flag.",". $rowperpage;


			//Changes when ALL category
			$orderASC = " ASC  ";

			if($priceSort == "highfirst"){
				$orderASC = " DESC  ";
			}
			if($priceSort == "releasednew"){
				$orderASC = " ";
			} 
			if($priceSort == "releasedold"){
				$orderASC = " ";
			}  
			 
			if($customArray['category'] == "all" || $parameters->categoriesAll == "all"){	 
				//$queryPage = $orderASC;
				$queryPage = $orderASC.$offsetLimit;
			}else{ 
				$queryPage = $orderASC.$offsetLimit;
			}
			 
		 

			/******* 
			 * COmbined all query and final query 
			 * 
			 * ***********************/

			$queryFinal = $queryStart.$queryMidFinal.$queryData.$queryPage;

			/******************** DEBUG ********************/
			if($queryStart){
				$debug .= " queryStart = YES / ";
			}
			if($queryMidFinal){
				$debug .= " queryMidFinal = YES / ";
			}
			if($queryData){
				$debug .= " queryData = YES / ";
			}
			if($queryPage){
				$debug .= " queryPage = YES / ";
			}
			//echo $debug;
			 /******************** DEBUG ********************/

			$query = $this->db->query($queryFinal);
			$resultsCount = $query->num_rows();
			$results = $query->result();
  
  
				$getCategoryProductsCache = $results;
			 
			
			//CREATE Cache --------------------------------------------------------------- NOTE ------------------------------------------------
			

			//COunt
			$queryASC= $orderASC;
			$queryCount= $queryStart.$queryMidFinal.$queryData.$queryASC;
			$queryCountTemp = $this->db->query($queryCount);
			$queryCountRows = $queryCountTemp->num_rows();
			//COunt
			 
			//return array('categories'=>$results, 'categoriesAllCount' => $queryCountRows, 'filteredCount' => $resultsCount) ;
			return array('categories'=>$getCategoryProductsCache, 'categoriesAllCount' => $queryCountRows, 'filteredCount' => $resultsCount) ;
			 

	}


	public function SearchCustomFilter($values){
						$names = explode( ',', $values );
						// Trim all the elements to remove whitespaces
						$names = array_map( 'trim', $names );
						// Remove empty elements
						$names = array_filter( $names );
						$brandwhere = array();
						$brandwhere2 = array();

						// Loop over each, placing the "LIKE" clause into an array
						$bw = 1;
						for($i=1; $i <= 10; $i++){

							if($bw != 1){
								$Ors = " OR ";
							}else{
								$Ors = " ";
							}

							$brandwhere[] =  "  ".$Ors."  Active != 0 ".$availQuery." AND (";
							$xc = 1; 
							foreach( (array)$names AS $name ) {
								 
								if($xc != count($names)){
									$OR = " OR ";
								}else{
									$OR = " ";
								} 
								$brandwhere[] = "  PrintType".$i." LIKE '".$name."'  ".$OR." ";
								$xc++;
							}  
							
							$brandwhere[] =  " )  ";

							$bw++;
						}
						 
						$brandwhere  = '' .implode('  ', $brandwhere). '';

						$queryBrand =  " AND ( ".$brandwhere." ) "; 

						return $queryBrand;


	}

	public function breadCrumbs($getCategoryName,  $customArray, $getItem=null){
		 
			$customID = "";
			$homecustomID = "";
			if(count($customArray['customerAccount']) > 0){
					$customID = $customArray['customID'];
					$homecustomID = "home".$customID;
					if($customArray['themeDomain'] == 1){
							$customID = "";
							$homecustomID = "";
					} 
			}

			$htmlb = "";
			//$htmlb .="<div class='btn-group btn-breadcrumb margin-bottom'>";
			//$htmlb .="<a href='".base_url().$homecustomID."' class='btn btn-default'><i class='fa fa-home' aria-hidden='true'></i></a>"; 
			$htmlb .="<div class='breadcrumbnew '>"; 
			$htmlb .="<a href='".base_url().$homecustomID."'  >Home</a>";                                             
							
			if($getCategoryName['mainCategory']){
					//$htmlb .= "<a href='/category/".$getCategoryName['mainCategory']['mainCategoryNumber'].$customID."' class='btn btn-default'>".$getCategoryName['mainCategory']['mainCategoryName']."</a>";
					$htmlb .= " / <a href='/category/".$getCategoryName['mainCategory']['mainCategoryNumber'].$customID."'  >".$getCategoryName['mainCategory']['mainCategoryName']."</a>";
			}

			if($getCategoryName['categoryPage'][0]->CategoryNum){
					$expItem = explode("-",$getCategoryName['categoryPage'][0]->CategoryNum);
					
					$all = "/all";
					if($expItem[1] == 0){
						$all = "";
					}
					if($getCategoryName['categoryPage'][0]->CategoryNum == '555-0'){
						$CategoryNum = '#';
					}else{
						$CategoryNum = '/category/'.$getCategoryName['categoryPage'][0]->CategoryNum.$all.$customID;
					}
					//$htmlb .= "<a href='".$CategoryNum."' class='btn btn-default'>".$getCategoryName['categoryPage'][0]->CategoryName."</a>";
					$htmlb .= " / <a href='".$CategoryNum."' >".$getCategoryName['categoryPage'][0]->CategoryName."</a>";
			}

			if($getItem != null){
					//$htmlb .= "<a href='/item/".$getItem[0]->Code.$customID."' class='btn btn-default'>".$this->general_model->cleanString($getItem[0]->Name)."</a>";
			}
			
			$htmlb .="</div>";
			return $htmlb;
	}



	  
	
	 
}
