<?php



    /********* Component API  ******************/
    function AuthCient(){
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

    function Components($stockcode){

		$client = AuthCient();   
        $params = array
		(
			'StockCode' => $stockcode
		);
		try
		{
            $result = $client->Components($params);  
            //$resultArray = json_decode($result->ComponentsResult->Components->Component, true);  
		}
		catch (Exception $ex)
		{ 
			$resultArray  = $ex->getMessage(). "\n";
			die();
		}  
		return $result; 
    }
     
   /********* Component API  ******************/

   


?>