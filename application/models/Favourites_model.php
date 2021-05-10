<?php
 
class Favourites_Model extends CI_Model {

	public function __construct(){ 

		$this->load->model('general_model');  
		 
	}
	 
	function getFavouritesItems($userID, $siteLogcheck, $checkAvailCountry, $customArray){

		$access = $this->general_model->getAvailableProductAccess($siteLogcheck, $checkAvailCountry, $customArray);
		
		 
		$availQuery = $access['availQuery']; 
		$currencySort = $access['currencyAvailable']; 



		$results = null;
		$query = $this->db->query("SELECT * FROM userFavs WHERE userID = '".$userID."'  "); 
		$rowsNum = $query->num_rows();
		if($rowsNum > 0){
			$userFavs = $query->result();

			$myFavourite = array();
			foreach($userFavs as $fav){
				$myFavourite[] = $fav->productCode;
			}
			//print_r($customArray);
			$myFavouriteLists = implode(', ', $myFavourite); 
			
			$query = $this->db->query("SELECT * FROM  productsCurrent LEFT JOIN productsPricing ON productsPricing.Coode = productsCurrent.Code AND (productsPricing.Currency = '".$currencySort."') AND (productsPricing.PriceOrder = '1')  WHERE  ".$availQuery."  Code IN(".$myFavouriteLists.")    AND Active != 0 ORDER BY Code");
			$results = $query->result();

		}
		return $results;
		 
		//return $query->result();
	}

	function removeFavourite($code, $userID){
		$data = array(
			'userID' => $userID,
			'productCode' =>  $code
		);
		$deleted = $this->db->delete('userFavs', $data); 
		return $deleted;  
	}

	function checkFavourite($userID, $Code){
		$query = $this->db->query("SELECT * FROM userFavs WHERE userID = '".$userID."' AND productCode = '".$Code."'  "); 
		$rowsNum = $query->num_rows();

		return $rowsNum;
	}

	function addFavourite($userID, $Code){
		$datas = array(
			'userID' => $userID, 
			'productCode'=> $Code  
		); 
		$query = $this->db->query("SELECT * FROM userFavs WHERE userID = '".$userID."' AND productCode = '".$Code."'  "); 
		$rowsNum = $query->num_rows();
		if($rowsNum == 0){
			$results = $this->db->insert('userFavs', $datas); 
		}else{
			$results = null;
		} 
		return $results;
	}
	 
	 
}
