<?php
 
class Home_Model extends CI_Model {

	public function __construct(){ 
		$this->load->model('general_model'); 

		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"   ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tableAdditionalOptions = "additionalOptions";
		} else { 
			$this->tableBanners = "bannersTrendsnz";
			$this->tableProducts = "productsCurrent";
			$this->tableAdditionalOptions = "additionalOptions";
		}
	}

	function getFeaturedItems(){
		$query = $this->db->query("SELECT * FROM productsCurrent WHERE featuredItem > 0 AND Active = 1 ORDER BY featuredItem");
		return $query->result();
	}
	
	function getFeaturedProducts($siteLogcheck, $checkAvailCountry, $customArray){
		 
		$access = $this->general_model->getAvailableProductAccess($siteLogcheck, $checkAvailCountry, $customArray);
		 
		$availQuery = $access['availQuery']; 
		$currencySort = $access['currencyAvailable']; 
		
		$results = array();

		$brandingQueryDefault = " SELECT PricingType, ProductCode, costDescription, brandingMethod, brandingArea, orderRow, ".$currencySort."UnitPrice, ".$currencySort."OrderPrice  FROM ".$this->tableAdditionalOptions." ";
		$brandingQuery = " ( ".$brandingQueryDefault." WHERE orderRow = 1  GROUP BY ".$this->tableAdditionalOptions.".ProductCode) ";
		$additionalOptionsQuery = " LEFT JOIN   ".$brandingQuery."     ".$this->tableAdditionalOptions."   ON productsCurrent.Code =  ".$this->tableAdditionalOptions.".ProductCode  ";

 		 
		$query = $this->db->query("SELECT * FROM  productsCurrent  ".$additionalOptionsQuery."  LEFT JOIN productsPricing ON productsPricing.Coode = productsCurrent.Code AND (productsPricing.Currency = '".$currencySort."') AND (productsPricing.PriceOrder = '1')  WHERE ".$availQuery." featuredItem > 0 AND Active != 0 ORDER BY featuredItem");
		
		$results = $query->result();
		 
		
		if($results){
			 $resultsCount = count($results) - 1;
			 for($x = 0; $x <= $resultsCount; $x++){
				
				
				$searchCodeFeature = $results[$x]->Code;

				$queryFeature = $this->db->query("SELECT Image, Caption FROM segmentStockCode WHERE FGCode = '".$searchCodeFeature."'  AND Caption = 'Feature' LIMIT 1 ");
				if($queryFeature){
					//$results[$x]->FeaturedImageYes = "YEEEES";
					$selectedFeature = $queryFeature->row();
					 
					$results[$x]->FeaturedImageYes = $selectedFeature->Caption;
					$results[$x]->FeaturedImageNumber = $selectedFeature->Image;
				}

			 }
		}
	    
		/* 
		echo "<pre>";
		print_r($access);
		echo "</pre>"; */

		return $results;
	}

	

	function getAllProducts() {
		$query = $this->db->query("SELECT * FROM productsCurrent WHERE Active = ?", array(1));
		return $query->result();
	}

	

	function getMainBanner($siteLogcheck, $checkAvailCountry, $customArray){

		$results = array();
		$themeExists = 0;
		$userBannerExist = 0;
		$bannerLoc = "Banners_loggedout";
		
		if($siteLogcheck['userDatas'][0]->userID && $siteLogcheck['loggedIn'] == 1 && count($customArray['themeArray']) == 0) { 
			if($checkAvailCountry == "availNZ") {	
				$bannerLoc = "Banners_nz";
			} 
			if($checkAvailCountry == "availAU") {
				$bannerLoc = "Banners_au";
			}
			if($checkAvailCountry == "availSG") {
				$bannerLoc = "Banners_sg";
			}
			if($checkAvailCountry == "availMY") {
				$bannerLoc = "Banners_my";
			}

			/* $queryUsers =  dbPuller("SELECT userBanner FROM userData WHERE   userID = '".$userID."'  ",0);  
			while($userBanners = mysqli_fetch_array($queryUsers)) {  
				if($userBanners['userBanner']){
					 $userBannerExist = 1;
					 //$userBannersArray = explode(',', $userBanners['userBanner']);
					 $queryBannerUsers = dbPuller("SELECT  * FROM ".$tableBanners." WHERE location = 'Users' AND id IN (".$userBanners['userBanner'].")  AND active = '1' ORDER BY id ",0); 
					 while($userFinalBanners = mysqli_fetch_array($queryBannerUsers)) { 
						$BannerNew[] = $userFinalBanners;
					 }
				}
			} 
			$queryUser =   $this->db->query("SELECT userBanner FROM userData WHERE userID = '".$siteLogcheck['userDatas'][0]->userID."' " ); 
			$queryUserBanners = $queryUser->result();
			//print_r($queryUserBanners[0]->userBanner);
			if($queryUserBanners[0]->userBanner){
				$userBannerExist = 1;
				$queryFinalUsers = $this->db->query("SELECT  * FROM ".$this->tableBanners." WHERE location = 'Users' AND id IN (".$queryUserBanners[0]->userBanner.")  AND active = '1' ORDER BY id " );
				$results['bannersArrayUsers'] = $queryFinalUsers->result();
			} 
			print_r($results['bannersArrayUsers']); */
		  
			$distributorLocation ="Users/".$siteLogcheck['userDatas'][0]->CustomerNumber;
			$queryDistributors =  $this->db->query("SELECT * FROM ".$this->tableBanners." WHERE location LIKE '".$distributorLocation."'  AND active = '1' ORDER BY orderNum",0); 
			$queryDistributorBanners = $queryDistributors->result();
			
			if(count($queryDistributorBanners) > 0){
				//echo count($queryDistributorBanners);
				//print_r($queryDistributorBanners);
				$userBannerExist = 1;
				$results['bannersArrayUsers'] = $queryDistributorBanners;
				//echo "<hr />";
			}  
			 
		}

		if(count($customArray['themeArray']) > 0) {
			$bannerLoc = "Banners_loggedout"; 
			$queryTheme =   $this->db->query("SELECT * FROM ".$this->tableBanners." WHERE location LIKE '".$customArray['themeArray'][0]->themeID."'  AND active = '1' ORDER BY orderNum" ); 
			 
			if($queryTheme->num_rows() > 0){
				$themeExists = 1;
				$results['bannersArrayTheme'] = $queryTheme->result();   
			} 		 
			 
		}

		//echo $this->tableBanners. " / " .$bannerLoc ;  
		
		$query = $this->db->query("SELECT * FROM ".$this->tableBanners." WHERE location LIKE '".$bannerLoc."'  AND active = '1' ORDER BY orderNum");
		$results['bannersArray'] = $query->result(); 
		//print_r($results['bannersArray']); 	echo "<hr />";

		$queryMini = $this->db->query("SELECT * FROM ".$this->tableBanners." WHERE location LIKE '".$bannerLoc."' AND main = '0'  AND active = '1' ORDER BY orderNum");
		$results['miniBanners'] = $queryMini->num_rows(); 

		$results['themeBanners'] = 0; 
		$results['distributorsBanners'] = 0; 

		//Merge 2 arrays for banners
		if(count($customArray['themeArray']) > 0 && $themeExists == 1){
			$results['bannersArray'] = array_merge($results['bannersArrayTheme'], $results['bannersArray']);
			$results['miniBanners'] = $queryMini->num_rows(); 
			$results['themeBanners'] = 1; 
			$results['distributorsBanners'] = 0; 
		}

		if($siteLogcheck['userDatas'][0]->userID && $siteLogcheck['loggedIn'] == 1 && count($customArray['themeArray']) == 0 && $userBannerExist == 1) { 
			$results['bannersArray'] = array_merge($results['bannersArrayUsers'], $results['bannersArray']);
			$results['miniBanners'] = $queryMini->num_rows(); 
			$results['themeBanners'] = 0; 
			$results['distributorsBanners'] = 1; 
		}
 
		return $results;
		 
	}

	function eachBannerCheck($url ){
		/*$themeUrl = $themeUrl;
		$urlGiven = $url; 
		$toCheck   = 'trendscollection';  
		 
		 if( strpos( $urlGiven, $toCheck) !== false) { 
			$exploded_url = explode('/', $urlGiven); 
			  
			if(count($exploded_url) > 1){
				$exploaded = $exploded_url[0];  
				if( strpos( $urlGiven, $exploaded) !== false) {
					$eachBannerUrl =  str_replace($exploaded, "", $urlGiven);
					$eachBannerUrl = $eachBannerUrl.$themeUrl;
					 
					 
				} 
			}else{
				 
				$eachBannerUrl = "//".$urlGiven.$themeUrl;
				 
			} 
			 

		}else{
			$toCheck1   = 'http';  
			$toCheck2   = 'https'; 
			  
			if( strpos( $urlGiven, $toCheck1) !== false || strpos( $urlGiven, $toCheck2) !== false  ) { 
				$urlGiven = $urlGiven;
			}else{

				$toCheck3   = '/'; 
				if( strpos( $urlGiven, $toCheck3)  == true ) { 
					$urlGiven = $urlGiven.$themeUrl;
				}
				 $urlGiven = $urlGiven;
			}
			$eachBannerUrl = $urlGiven;
		}  
		return $eachBannerUrl; */

		$urlGiven = $url; 
		$toCheck   = 'trends';  
		 
		 if( strpos( $urlGiven, $toCheck) !== false) { 
			$exploded_url = explode('/', $urlGiven); 
			  
			if(count($exploded_url) > 1){
				$exploaded = $exploded_url[0];  
				if( strpos( $urlGiven, $exploaded) !== false) {
					$eachBannerUrl =  str_replace($exploaded, "", $urlGiven);
				} 
			}else{
				$eachBannerUrl = "//".$urlGiven;
			} 

		}else{
			$eachBannerUrl = $urlGiven;
		}  
		return $eachBannerUrl;
	}

	
	function checkPopup($opts, $url, $themeID){ 
		if($opts == 1){
			$pops = 'data-toggle="modal" data-target="#'.$url.'" href="#" ';
		} 
		if($opts == 0){
			
			if($url == "/" && $themeID){
				$url =  $themeID;
			}else{
				if($themeID){
					$readUrl = substr($url, 0, 4); 
					$readUrl2 = array();
					$readUrl2 = explode("issuu", $url);    
					if($readUrl == "http" || $readUrl2[0] == "//" || $readUrl2[0] == "//www." ){
						$themeID = "";
					} 

				 
					$bannerUrlArray = $this->bannerURLchecker($url, $themeID); 
					if($bannerUrlArray){ 
						if($bannerUrlArray['replaceUrl'] == 1){
							$url = $bannerUrlArray['newUrl'];
							$themeID = "";
						}
					}
						 
					 
 
				}
				$url = $url.$themeID;
			}
			$pops = ' href="'.$url.'" ';
		}
		if($opts == 2){
			$pops = ' href="'.$url.'"  target="_blank" ';
		}
		return $pops;
	} 

	public function bannerURLchecker($bannerUrl, $themeID){
		 
		//if()
		$results = array();
		//if($customArray['themeArray'][0]->Domain == ""){
			$pathUrl = explode("?", $bannerUrl);  
			//print_r($pathUrl);
			if($pathUrl[0] == "/category/products"){ 
				$results['replaceUrl'] = 1;
				$results['newUrl'] = $pathUrl[0].$themeID."?".$pathUrl[1];
			}  
			
			if(strpos($pathUrl[1], "&") !== false){
				$results['replaceUrl'] = 1;
				$results['newUrl'] = $pathUrl[0].$themeID."?".$pathUrl[1];
				//echo $pathUrl[0];
				if($pathUrl[0] == "/category/products".$themeID){ 
					$results['replaceUrl'] = 1;
					$results['newUrl'] = $pathUrl[0]."?".$pathUrl[1]; 
				}  
			}
			 
		//}
		return $results;	
	}
	
	
	 
}
