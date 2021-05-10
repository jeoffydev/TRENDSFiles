<?php
 
class Dashboard_Model extends CI_Model {

	 

	public function __construct(){ 
		if($_SERVER['SERVER_NAME'] == "logosource.co.nz" || $_SERVER['SERVER_NAME'] == "www.logosource.co.nz" || $_SERVER['SERVER_NAME'] == "localhost"  ) { 
			$this->tableBanners = "bannersDEV";
			$this->tableProducts = "productsCurrentDEV";
			$this->tablePricing = "productsPricingDEV";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChangesDEV";
			$this->productChangeTypes = "productChangeTypes";
			$this->orderRepeat = "orderRepeat";
		} else { 
			$this->tableBanners = "banners";
			$this->tableProducts = "productsCurrent";
			$this->tablePricing = "productsPricing";
			$this->tableStockCode = "segmentStockCode";
			$this->categoriesTable = "categoriesCurrent";
			$this->productsChanges = "productsChanges";
			$this->productChangeTypes = "productChangeTypes";
			$this->orderRepeat = "orderRepeat";
		}

		$this->load->library('email');
		$this->load->model('general_model');  

		$this->Username = '';
		$this->Password = '';
	}
	
	public function AuthCient(){
		$auth = array
		(
			'Username' => $this->Username,
			'Password' => $this->Password,
		);

		$client = new SoapClient('https://api.tuapeka.co.nz/trends/webservice.asmx?WSDL');
		$header = new SoapHeader('https://api.tuapeka.co.nz/trends/','UserCredentials',$auth,false);
		$client->__setSoapHeaders($header);
		 
		return $client;
	}

	 

	public function Orders($customerID){

		$client = $this->AuthCient();   
		$customerID = $customerID;
		$params = array
		(
			'CustomerID' => $customerID
		);
  
		try
		{
			$result = $client->Orders($params); 
			$resultArray = json_decode($result->OrdersResult, true);   
			
			 
		}
		catch (Exception $ex)
		{ 
			$resultArray  = $ex->getMessage(). "\n";
			die();
		} 

		return $resultArray;

	}

	public function Orders_Custom($customerID, $boolean, $limit){ 
  
		try
		{
			
			$client = $this->AuthCient();   
			$customerID = $customerID;
			$params = array
			(
				'CustomerID' => $customerID,
				'OpenOrdersOnly' => $boolean,
				'ResultLimit' => $limit
			);
			$result = $client->Orders_Custom($params); 
			$resultArray = json_decode($result->Orders_CustomResult, true);  
			 
		}
		catch (Exception $ex)
		{
			$resultArray = $ex->getMessage(). "\n";
			die();
		} 

		return $resultArray;

	}



	public function OrderNumbers($customerID){

		$client = $this->AuthCient();   
		$customerID = $customerID;
		$params = array
		(
			'CustomerID' => $customerID
		);
  
		try
		{
			$result = $client->OrderNumbers($params);  
			
			 
		}
		catch (Exception $ex)
		{ 
			$resultArray  = $ex->getMessage(). "\n";
			die();
		} 

		return $result;

	}


	

	public function Media($JobNumber, $MediaType ){

		$client = $this->AuthCient();   
		$customerID = $customerID;
		$params = array
		(
			'JobNumber' => $JobNumber,
			'MediaType' => $MediaType 
		);
  
		try
		{
			$result = $client->Media($params); 
			$resultArray = json_decode($result->MediaResult, true);  
			 
		}
		catch (Exception $ex)
		{
			$resultArray = $ex->getMessage(). "\n";
			die();
		} 

		return $result->MediaResult;

	}


	public function OrderLines($JobNumber){

		$client = $this->AuthCient();   
		$customerID = $customerID;
		$params = array
		(
			'OrderNumber' => $JobNumber 
		);
  
		try
		{
			$result = $client->OrderLines($params); 
			$resultArray = json_decode($result->OrderLinesResult->OrderLines->OrderLine, true);  
			 
		}
		catch (Exception $ex)
		{
			$resultArray = $ex->getMessage(). "\n";
			die();
		} 

		return $result;

	}


	public function OrderLinesCount($JobNumber){

		$client = $this->AuthCient();   
		$customerID = $customerID;
		$params = array
		(
			'JobNumber' => $JobNumber 
		);
  
		 
		$result = $client->OrderLines($params); 
		$resultCount = count(json_decode($result->OrderLinesResult, true));  
			 
		 
		return $resultCount;

	}



	public function ConvertToImage($jobNumber){
		$files = $this->Media($jobNumber, "photo"); 
		$base64_image = base64_encode($files); 

		return $base64_image;
		//return '<img src="data:image/gif;base64,' . $base64_image . '" />';
	}


 

	public function OrderDashboardTracker($email, $userID){
		$datas = array(
			'UserID' => $userID,
			'UserEmail' => $email 
		); 
		$this->db->insert('orderDashboardTracker', $datas); 
	}


	public function SendToDBAndEmail($datas){
		 //echo $datas->SalesOrder. " / " .$datas->userID;
		 //print_r($datas);

		 if($datas->SalesOrder && $datas->userID){
			//Insert To Db $this->orderRepeat // orderRepeat 
			$dataSave = array(
				'UserID' => $datas->userID,
				'OriginalSONumber' => $datas->SalesOrder,
				'DistributorName'=> $datas->DistributorName,
				'NewPO' => $datas->PON,
				'EmailContact'=> $datas->email,
				'Quantity'=> $datas->Quantity,
				'ShippingAddress'=> $datas->Address,
				'DecorationProcess'=> $datas->DecorationProcess,
				'ProductDescription'=> $datas->ProductDescription,
				'RequiredDate'=> $datas->date,
				'Note'=> $datas->Note 
			);  
			$inserted = $this->db->insert('orderRepeat', $dataSave); 
			//Insert To Db $this->orderRepeat // orderRepeat


			//Send to email TGP Staff

			if($inserted){ 

				$to = 'orders@trends.nz';
				$from = 'info@trends.nz';
				//$to = 'jeoffyh@tuapeka.co.nz';
				$subject = "ORDER REPEAT" ;
				$body = "A repeat order has been placed online. Please create a new order <br /><hr />";
				$body .= "<b>Previous SO Number:</b> ".$datas->SalesOrder." <br /><br />";
				$body .= "<b>Email Contact:</b> ".$datas->email."<br /><br />";
				$body .= "<b>Distributor Name:</b> ".$datas->DistributorName."<br /><br />";
				$body .= "<b>New PO:</b> ".$datas->PON."<br /><br />";
				$body .= "<b>Quantity:</b> ".$datas->Quantity."<br /><br />";
				$body .= "<b>Shipping Address:</b> ".$datas->Address."<br /><br />";
				$body .= "<b>Product Description:</b> ".$datas->ProductDescription."<br /><br />";
				$body .= "<b>Decoration Process:</b> ".$datas->DecorationProcess."<br /><br />";  
				$body .= "<b>Delivery Required by:</b> ".$datas->date."<br /><br />";
				$body .= "<b>Note:</b> <span style='color:#000; background-color:#FFFF00' > ".$datas->Note." </span><br />";

				$this->email->from($from, 'TRENDS');
				$this->email->to($to);
				$list = array($datas->email);
				$this->email->cc($list);
				$this->email->reply_to($datas->email, $datas->DistributorName);

				$this->email->subject($subject);
				$this->email->message($body);
				$this->email->set_mailtype("html");


				//Forward to Customer
				/*if($to){
					$this->email->from($from, 'Order Repeat Copy');
					$this->email->to($datas->email); 
					$this->email->subject($subject);
					$this->email->message($body);
					$this->email->set_mailtype("html");
				}*/



				
				if($this->email->send()){
					$results = 1;

					
					
					

				}else{
					$results = 0;
				}
				return  $results;  

			} 
		 }  
	}

	public function checkOrderRepeat($salesOrder, $opt=null){  
		$this->db->select('*')->from($this->orderRepeat)->where('OriginalSONumber', $salesOrder); 
		$q = $this->db->get(); 

		$results =array();
		$results['records'] = 0;

		$results['numrows'] = $q->num_rows(); 
		if($results['numrows'] > 0){
			$results['records'] = $q->result();;
		}

		return $results;
		 
	}



	
	 
}
