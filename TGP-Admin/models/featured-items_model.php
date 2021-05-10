<?php 
 
class FeaturedModel{
   
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
            if($opt == 3){
                $Table = $colourSearchTable;
            }
            if($opt == 4){
                $Table = $changeTypeTable;
            }
            if($opt == 5){
                $Table = $cmsTrackTable;
            }
            
        }
        return $Table;
     }
     
     public function selectProductsCurrent($table){    
        
        $table = $this->getTable($table);   
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT * FROM  '.$table.' WHERE Active != 0 '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;
     }


     public function getFeaturedProducts($table){
        $table = $this->getTable($table);   
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query("SELECT Prim, Code, Name, featuredItem FROM ".$table." WHERE featuredItem > 0 AND Active != 0 ORDER BY featuredItem "); 
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