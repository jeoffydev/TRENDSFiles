<?php 
 
class AdditionalCost{
   
    public function getTable($table, $opt=null){
        if($table == 2){
            //Declare all the Live table here
            $Table = 'productsCurrent';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $TablePricing = 'productsPricing';
            $cmsTrackTable = 'CMSeditPageTracker';
            $customerData = 'customerData';
            $currencyData = 'currencyData';
            $userData = 'userData';
        }else{
            //Declare all the Dev table here
            $Table = 'productsCurrentDEV';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $TablePricing = 'productsPricingDEV';
            $cmsTrackTable = 'CMSeditPageTracker';
            $customerData = 'customerData';
            $currencyData = 'currencyData';
            $userData = 'userData';
        } 
        if($opt != null){
            if($opt == 2){
                $Table = $TablePricing;
            }
            if($opt == 3){
                $Table = $colourSearchTable;
            }
            if($opt == 4){
                $Table = $changeTypeTable;
            }
            if($opt == 5){
                $Table = $cmsTrackTable;
            }
            if($opt == 6){
                $Table = $customerData;
            }
            if($opt == 7){
                $Table = $currencyData;
            }
            if($opt == 8){
                $Table = $userData;
            }
           
            
        }
        return $Table;
     }

     public function AuthCient(){
		$auth = array
		(
			'Username' => 'AD9HV805xhn3CTHMyEypqw==',
			'Password' => 'liWiUxXdYZ4Qppxke/fK8A==',
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
    

    
    public function Components($stockcode){

		$client = $this->AuthCient();   
        $params = array
		(
			'StockCode' => $stockcode
		);
		try
		{
			$result = $client->Components($params); 
			 
		 
		}
		catch (Exception $ex)
		{ 
			$resultArray  = $ex->getMessage(). "\n";
			die();
		} 

		return $result;

	}


     
     public function selectProductsCurrent($table){    
        
        $table = $this->getTable($table);   
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT * FROM  '.$table.' ORDER BY Code '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;
     }

     public function getCustomerData($table){    
        
        $table = $this->getTable($table, 6);   
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT CustomerNumber, CustomerName, Currency, CustomerOnHold, CSR FROM  '.$table.'  ORDER BY customerName '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;
     }
 

     public function getCurrencyData($table){    
        
        $table = $this->getTable($table, 7);   
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT * FROM  '.$table.'  ORDER BY currencyID '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;
     }

     public function getUserData($table){    
        
        $table = $this->getTable($table, 8);   
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT userID, userAcct, userEmail, userHash, userType, multiCurrency, apiAcc, skinnedWebsites, customSiteUser, CustomerNumber, CustomerName,  Currency, CustomerOnHold, visualAccess, CSR 
        FROM  '.$table.'  JOIN  customerData ON '.$table.'.userAcct = customerData.CustomerNumber ORDER BY userID DESC '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;
     }

     
     public function getCustomerDataNo($table){    
        
        $table = $this->getTable($table, 6);   
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT * FROM  '.$table.' WHERE CustomerOnHold = "N" ORDER BY customerName  '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;
     }

     public function getTheTable($table){
        $table = $this->getTable($table);  
        return $table;
    }

    public function detectUserID($table, $userID){
        $table = $this->getTable($table, 5);  
        $conn = Db::getInstance();
        $stmt1 = $conn->prepare('SELECT * FROM '.$table.' WHERE  userID=?  ');
        $stmt1->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC); 
        if($row1 > 0){ 
            $results = $row1;
        }else{
            $results = 0;
        }
        return $results;
    }

    public function detectDeleteUserID($table, $userID){
        $table = $this->getTable($table, 5);  
        $conn = Db::getInstance();
        $command = " DELETE FROM ".$table." WHERE userID=:userID";
        $stmt = $conn ->prepare($command);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $done = $stmt->execute();
        return $done;
    }
 

}


?>