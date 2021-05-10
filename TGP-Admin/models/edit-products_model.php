<?php 
 
class EditProductModel{
 
    public function getTable($table, $opt=null){
        if($table == 2){
            //Declare all the Live table here
            $Table = 'productsCurrent';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $changeTypeTable = 'productChangeTypes';
            $cmsTrackTable = 'CMSeditPageTracker';
            $despatchTable = 'despatchLocation';
            $currencyData = 'currencyData';
        }else{
            //Declare all the Dev table here
            $Table = 'productsCurrentDEV';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $changeTypeTable = 'productChangeTypes';
            $cmsTrackTable = 'CMSeditPageTracker';
            $despatchTable = 'despatchLocation';
            $currencyData = 'currencyData';
        } 
        if($opt != null){
            if($opt == 2){
                $Table = $catTable;
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
                $Table = $despatchTable;
            }
            if($opt == 7){
                $Table = $currencyData;
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
        $req = $conn->query('SELECT * FROM  '.$table.' '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;
     }
     //Select ID 
     public function selectProductID($id, $table){    
        $conn = Db::getInstance();
        $table = $this->getTable($table);   
        $req = $conn->query("SELECT * FROM ".$table." WHERE Prim =  :id "); 
        $req->execute(array('id' => $id));
        $results = $req->fetch();
        return $results;
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

     public function selectCategories($table){
         $table = $this->getTable($table, 2);  
         $conn = Db::getInstance();
         $req = $conn->query("SELECT * FROM ".$table." WHERE CategoryNum LIKE '%-0'   ORDER BY CategoryOrder"); 
         $results = $req->fetchAll(PDO::FETCH_ASSOC); 
         return $results;
     }

     public function selectDespatchLocations($table){
        $table = $this->getTable($table, 6);  
         
        $conn = Db::getInstance();
        $req = $conn->query("SELECT * FROM ".$table."  ORDER BY Prim"); 
        $results = $req->fetchAll(PDO::FETCH_ASSOC); 
        return $results;  
     }

     public function selectSubCategories($table, $subCat){
         $subCatVal = explode("-",$subCat);
         $subCatValue = $subCatVal[0];
         $table = $this->getTable($table, 2);    
         $conn = Db::getInstance();
         $req = $conn->query("SELECT * FROM ".$table." WHERE CategoryNum LIKE '".$subCatValue."-%' AND CategoryNum NOT LIKE '".$subCatValue."-0' ORDER BY CategoryName"); 
         $results = $req->fetchAll(PDO::FETCH_ASSOC); 
         return $results;  
     }

     public function selectColourSearch($table){
        $table = $this->getTable($table, 3);  
        $conn = Db::getInstance();
        $req = $conn->query("SELECT * FROM ".$table."  ORDER BY colourOrder ASC"); 
        $results = $req->fetchAll(PDO::FETCH_ASSOC); 
        return $results;
    }

    public function getChangeTypes($table){
        $table = $this->getTable($table, 4);  
        $conn = Db::getInstance();
        $req = $conn->query("SELECT * FROM ".$table."  ORDER BY indexNum ASC"); 
        $results = $req->fetchAll(PDO::FETCH_ASSOC); 
        return $results;
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


    public function checkTheTable($table, $repair){
        $table = $this->getTable($table);  

       
        error_reporting(E_ALL ^ E_DEPRECATED);
        $con=mysql_connect("localhost","trends_WebWrite","cwpTtvtC5VkA3kOVyFko"); 
        if (!$con) 
        { 
            die('Could not connect: ' . mysql_error()); 
        } 
        mysql_select_db("trends_collection", $con);  
        
        if($repair ==  2){ 
            $qry=mysql_query("REPAIR  table ".$table." ");
            if($qry){
                echo $table. " successfully repaired";
            } 
        }else{
            
            $qry=mysql_query("check table ".$table." ");
            echo "<table class='table table-bordered'> 
            <tr> 
            <th>TableName</th>  
            <th>MsgType</th>
            <th>MsgText</th>  
            </tr>"; 
            while($row = mysql_fetch_array($qry)) 
            { 
                echo "<tr>"; 
                echo "<td>" . $row['Table'] . "</td>";  
                echo "<td>" . $row['Msg_type'] . "</td>"; 
                echo "<td>" . $row['Msg_text'] . "</td>";
                echo "</tr>"; 
            } 
            echo "</table>"; 
        }
        
        mysql_close($con); 
                
    }

}


?>