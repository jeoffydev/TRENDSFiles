<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');

class   Hitpromo  {

	/* Add this library in controller 
	 
		$this->load->library('hitpromo');
		and on the method:
		print_r($this->hitpromo->index('57'));

	*/
 
	private $hitProduct = 1;
	private $finalResults = array();

	public function __construct()
	{
		$CI =& get_instance();
    	$CI->load->helper('url');
		 
	}

	 
	public function  index($paramValue){ 
		

		try { 
			$client = new SoapClient('https://ppds.hitpromo.net/inventoryV2', array("exceptions" => true, "connection_timeout"=>4));
		} catch ( SoapFault $e ) { // Do NOT try and catch "Exception" here
			$blurbText = "Please contact your Account Manager for stock availability information.";
			$this->hitProduct = 0;
		}
 
		if ($this->hitProduct != 0) { 
			try { 
				
				$params = array(
					"wsVersion" => '2.0.0',
					"id" => '',
					"password" => '',
					"productId" =>  $paramValue,
				  ); 
				   
				$response = $client->getInventoryLevels($params);
				$arrayOne = json_decode(json_encode($response), True); 
				$arraytwo = $arrayOne['Inventory']['PartInventoryArray']['PartInventory'];
				/*
				echo "<pre>";
				print_r($arraytwo);
				echo "</pre>"; */
				 
				if (array_key_exists("partId",$arraytwo)){
					$qtyFinal = $arraytwo['quantityAvailable']['Quantity']['value']; 
					$this->finalResults[] = array('color'=> $arraytwo['partColor'], 'quantity_available'=> $qtyFinal); 
				}else{
					$countAPI = count($arraytwo) - 1;  
					for($i = 0; $i <= $countAPI; $i++){ 
						 $qtyFinal = $arraytwo[$i]['quantityAvailable']['Quantity']['value']; 
						 $this->finalResults[] = array('color'=> $arraytwo[$i]['partColor'], 'quantity_available'=> $qtyFinal);
					}
				}  
				 
			} catch ( SoapFault $e ) { 
				$blurbText = "Please contact your Account Manager for stock availability information.";
				$hitProduct = 0;
			} 

			
		}
		return $this->finalResults; 
	}
 
	
}
