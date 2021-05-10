<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updatedata extends CI_Controller {
	

	public function __construct(){ 
		parent:: __construct();  
		$this->load->model('general_model');  
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



	 

	public function index()
	{
		$catArray="103-9,103-8,103-5,103-4,103-3,103-2,103-1,103-10";
		//$catArray="103-5,103-9,103-8,103-10";
		$array=explode(',', $catArray); 

		$res = array();
		foreach($array as $row){

			//$this->db->query("UPDATE productsCurrent SET Category1, Category2, Category3, Category4, Category5, Category6, Category7, Category8 WHERE Code = '107665' AND Category1 = '".$row."' OR Category2 = '".$row."' OR Category3 = '".$row."' OR Category4 = '".$row."' OR Category5 = '".$row."' OR Category6 = '".$row."' OR Category7 = '".$row."' OR Category8 = '".$row."' ");
			 
			$query = $this->db->query("SELECT Prim, Code, Name, Category1, Category2, Category3, Category4, Category5, Category6, Category7, Category8 FROM productsCurrent WHERE Category1 = '".$row."' OR Category2 = '".$row."' OR Category3 = '".$row."' OR Category4 = '".$row."' OR Category5 = '".$row."' OR Category6 = '".$row."' OR Category7 = '".$row."' OR Category8 = '".$row."' ");
			$res[]  = $query->result();

			//if()
			 
		}
		$count = count($res);
		//$query = $this->db->query("SELECT Code, Name FROM users WHERE id IN ('".$array."')");
		//$results = $query->result();
		

		for($x=0; $x < $count; $x++ ){
			
				foreach($res[$x] as $row2){
					$res2[]  = $row2;
				}

		}
		

		 $count2 = count($res2);

		for($y=0; $y < $count2; $y++ ){ 
			echo $res2[$y]->Code. " => " ; 

			if($res2[$y]->Category1){
				if (in_array($res2[$y]->Category1, $array)) 
				{
					echo "Cat 1.....................";
					$this->UpdateCategories('Category1', $res2[$y]->Code);
				}
			}

			if($res2[$y]->Category2){
				if (in_array($res2[$y]->Category2, $array)) 
				{
					echo "Cat 2.....................";
					$this->UpdateCategories('Category2', $res2[$y]->Code);
				}
			}
 
			if($res2[$y]->Category3){
				if (in_array($res2[$y]->Category3, $array)) 
				{
					echo "Cat 3.....................";
					$this->UpdateCategories('Category3', $res2[$y]->Code);
				}
			}

			if($res2[$y]->Category4){
				if (in_array($res2[$y]->Category4, $array)) 
				{
					echo "Cat 4.....................";
					$this->UpdateCategories('Category4', $res2[$y]->Code);
				}
			}

			if($res2[$y]->Category5){
				if (in_array($res2[$y]->Category5, $array)) 
				{
					echo "Cat 5.....................";
					$this->UpdateCategories('Category5', $res2[$y]->Code);
				}
			}


			if($res2[$y]->Category6){
				if (in_array($res2[$y]->Category6, $array)) 
				{
					echo "Cat 6.....................";
					$this->UpdateCategories('Category6', $res2[$y]->Code);
				}
			}

			if($res2[$y]->Category7){
				if (in_array($res2[$y]->Category7, $array)) 
				{
					echo "Cat 7.....................";
					$this->UpdateCategories('Category7', $res2[$y]->Code);
				}
			}


			if($res2[$y]->Category8){
				if (in_array($res2[$y]->Category8, $array)) 
				{
					echo "Cat 8.....................";
					$this->UpdateCategories('Category8', $res2[$y]->Code);
				}
			}
 

			

		}	
		echo "------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
	 
		echo "Count is ".$count2;
		echo "------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------";
	 
	 	echo "<pre>";
		print_r($res2);
		echo "</pre>";  

	}

	function UpdateCategories($category, $code){
		//return "UPDATE productsCurrent SET  ".$category." = '0'  WHERE Code = '".$code."'  ";
		//return  $this->db->query("UPDATE productsCurrent SET  ".$category." = '0'  WHERE Code = '".$code."'  ");
		//return "Okay ".$category. " = " .$code;
	}
		

		 
 
	 

	
}
