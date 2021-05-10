<?php 
 
class AddProductModel{
 
    public function getTable($table, $opt=null){
        if($table == 2){
            //Declare all the Live table here
            $Table = 'productsCurrent';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $changeTypeTable = 'productChangeTypes';
            $cmsTrackTable = 'CMSeditPageTracker';
            $TableBeta = 'productsCurrentBETA';
        }else{
            //Declare all the Dev table here
            $Table = 'productsCurrentDEV';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $changeTypeTable = 'productChangeTypes';
            $cmsTrackTable = 'CMSeditPageTracker';
            $TableBeta = 'productsCurrentBETA';
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
                $Table = $TableBeta;
            }
        }
        return $Table;
     }

     public function selectProductsCurrentBeta($table){     
        $table = $this->getTable($table, 6);  
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT Code, Name, Size, Category1, Category2, Category3, Category4, Category5, Category6, Category7, Category8, Status, Description , Dimension1, Dimension2, Dimension3, sizingLine1, sizingLine2, sizingLine3, sizingLine4, PrintType1, PrintDescription1, PrintType2, PrintDescription2, PrintType3, PrintDescription3, PrintType4, PrintDescription4, PrintType5, PrintDescription5, PrintType6, PrintDescription6, PrintType7, PrintDescription7, PrintType8, PrintDescription8, PrintType9, PrintDescription9, PrintType10, PrintDescription10, Colours, ColoursSecondary, video, Packing, cartonLength, cartonWidth, cartonHeight, cartonWeight, cartonQuantity, Keywords, ColorSearch, StockComment, PenIndent, PlacementWeighting,  ImageCount,  FullColour,  IsMixMatch,  IsPen,  StockWizDisable,  PDFDisable,  Active,  ExclusiveItem,  visualsAvailable,  IsIndent, IsIndentExpress,  featuredItem, HitSKU, Materials, Specifications FROM  '.$table.' ORDER BY Prim  '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;  
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

     public function selectCategories($table){
         $table = $this->getTable($table, 2);  
         $conn = Db::getInstance();
         $req = $conn->query("SELECT * FROM ".$table." WHERE CategoryNum LIKE '%-0'   ORDER BY CategoryOrder"); 
         $results = $req->fetchAll(PDO::FETCH_ASSOC); 
         return $results;
     }

     public function selectSubCategories($table, $subCat){
         $subCatVal = explode("-",$subCat);
         $subCatValue = $subCatVal[0];
         $table = $this->getTable($table, 2);    
         $conn = Db::getInstance();
         $req = $conn->query("SELECT * FROM ".$table." WHERE CategoryNum LIKE '".$subCatValue."-%' ORDER BY CategoryName"); 
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