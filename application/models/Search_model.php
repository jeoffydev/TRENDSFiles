<?php

 
 
class Search_Model extends CI_Model {

	public function __construct(){ 
		parent:: __construct();  
	 
		/* Variables  */
		
		$this->load->model('general_model'); 

		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) {  
			$this->tableItems = "productsCurrentDEV";
			$this->tableCategories = "categoriesCurrent";
			$this->colourSearch = "colourSearch";
		} else { 
			$this->tableItems = "productsCurrent";
			$this->tableCategories = "categoriesCurrent";
			$this->colourSearch = "colourSearch";
		}

		$this->domainCheck = "0";  
		$this->category = null; 
 
	}

	function searchForm($availAccess, $siteLogcheck, $customArray){
		 
		 
		if($siteLogcheck['userDatas'][0]->multiCurrency != 0 && $siteLogcheck['loggedIn'] == 1 && count($customArray['customerAccount']) == 0  ) {
			//$availAccess = " ";
		}

		$results = array();

		

		$query =  $this->db->query(" SELECT Code, Name     FROM ".$this->tableItems." WHERE (Active = 1   ".$availAccess." AND CONCAT_WS('      ', Category1, Category2, Category3, Category4, Category5, Category6) NOT LIKE '%2__-%') ORDER BY IsIndentExpress ASC, Code ASC"); 
        
		$dataSearchItemPullResults = $query->result();   

		$arrayName = array();
		



		foreach($dataSearchItemPullResults as $row){
			$arrayName[] = $row->Name." ";
		}
		$implodeNames = implode(" ", $arrayName);
		$img0 = '<img  src="/Images/SearchIcons/rtSearchMore.png" width="40px" height="40px" border="0px"  >';
		$results[] =  array('Name' =>  $implodeNames, 'Code' => 0, 'img0'=> $img0, 'Optin' => 0);  

		$query =  $this->db->query(" SELECT CategoryName, CategoryNum FROM ".$this->tableCategories." WHERE  CategoryNum NOT LIKE '___-%'   "); 
        $dataSearchCategoriesPullResults = $query->result();   
		foreach($dataSearchCategoriesPullResults as $row3){ 
				$img2 = '';
				
				$getCatval = substr($row3->CategoryNum, -1);
				$categoryNum =  $row3->CategoryNum;
				
				if(strlen($row3->CategoryNum) > 4){
					$getCatval = substr($row3->CategoryNum, -2);
				}

				$getCatvalTen = substr($row3->CategoryNum, -2);
				if($getCatvalTen == 10){
					$getCatval = 10;
				}

				if($getCatval != 0){
					$categoryNum =  $row3->CategoryNum.'/all';
				}
				

				$results[] =  array('Name' => $this->general_model->cleanSearchTop($row3->CategoryName), 'Code' => $categoryNum,  'img2'=>$img2,  'Optin' => 2);  
			 
		}  

		foreach($dataSearchItemPullResults as $row){
			$imgAppend = date("dHi"); 
			$img = '<img  src="/Images/ProductImgSML/'.$row->Code.'-0.jpg?'.$imgAppend.'" width="40px" height="40px" border="0px"  >';
			$results[] =  array('Name' => $this->general_model->cleanSearchTop($row->Name), 'Code' => $row->Code, 'img'=>$img, 'Optin' => 1); 
		}

		/*
		$query =  $this->db->query(" SELECT nameSearch, nameTitle, hexCode FROM ".$this->colourSearch."  ORDER BY nameSearch ASC  "); 
        
		$dataSearchColoursPullResults = $query->result();   
		foreach($dataSearchColoursPullResults as $row2){
			 
				$results[] =  array('colourCode' => $row2->hexCode, 'Name' => $row2->nameTitle, 'Code' => $row2->nameSearch, 'Optin' => 3);  
			 
		}  */

		
 
		return $results;
	}
 
 
 
 
 
}
