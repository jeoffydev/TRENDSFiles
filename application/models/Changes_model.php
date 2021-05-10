<?php
 
class Changes_Model extends CI_Model {

	public function __construct(){ 
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tablePricing = "productsPricingDEV";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChanges";
			$this->productChangeTypes = "productChangeTypes";
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChanges";
			$this->productChangeTypes = "productChangeTypes";
		}

		$this->load->model('productsdisplay_model');
		$this->load->model('general_model');
	}

	function changesInsertUpdate($changesform){



		$object = array(
			'changeType' => $changesform['changeType'], 
			'Description' =>  $changesform['changesDesc'],
			'Code' => $changesform['changesItemCode']
		);
		if($changesform['opts'] == 1){
			$results =	$this->db->insert($this->productsChanges, $object);
		}

		if($changesform['opts'] == 2){
			 $data = array(
				'changeType' => $changesform['changeType'], 
				'Description' =>  $changesform['changesDesc'],
		    );
			$this->db->where('indexNum', $changesform['indexNum']);
			$results = $this->db->update($this->productsChanges, $data); 

		 
		}
		  
		return $results;
	}

	function deleteChanges($indexNum){
		$this->db->where('indexNum', $indexNum);
		$results = $this->db->delete($this->productsChanges);
		return $results;
	}

	function getChangesDetails($indexNum){
		$getChanges = $this->db->query("SELECT * FROM ".$this->productsChanges." WHERE indexNum = '".$indexNum."' ");
		$rowChangeResults = $getChanges->row();
		return $rowChangeResults;
	}
 
	
	function getChangeType(){
		$resultChangeType = $this->db->query("SELECT * FROM ".$this->productChangeTypes." ");
		$rowChangeType = $resultChangeType->result();

		return $rowChangeType;
	}

	function getTheChangeType($type){

		$resultChangeType = $this->db->query("SELECT * FROM ".$this->productChangeTypes." WHERE indexNum = '".$type."' ");
		$rowChangeType = $resultChangeType->row(); 
		return $rowChangeType->changeType;
	}
 
 
	
	 
}
