<?php 
 
class HomeModel{
   
    public function getTable($table, $opt=null){
        if($table == 2){
            //Declare all the Live table here
            $Table = 'productsCurrent';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $TablePricing = 'productsPricing';
            $cmsTrackTable = 'CMSeditPageTracker';
        }else{
            //Declare all the Dev table here
            $Table = 'productsCurrentDEV';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $TablePricing = 'productsPricingDEV';
            $cmsTrackTable = 'CMSeditPageTracker';
        } 
        if($opt != null){
            if($opt == 2){
                $Table = $TablePricing;
            }
            if($opt == 5){
                $Table = $cmsTrackTable;
            }
             
        }
        return $Table;
     }

     public function countActiveProducts($table){
        $table = $this->getTable($table);  
        $conn = Db::getInstance();
        $req = $conn->query("SELECT * FROM ".$table." "); 
        $results = $req->fetchAll(PDO::FETCH_ASSOC); 
        $results = count($results);
        return $results;
    }

    public function countNzdPricing($table, $currency){
        $table = $this->getTable($table, 2);  
        $conn = Db::getInstance();
        $req = $conn->query("SELECT * FROM ".$table." WHERE Currency = '".$currency."' "); 
        $results = $req->fetchAll(PDO::FETCH_ASSOC); 
        $results = count($results);
        return $results;
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