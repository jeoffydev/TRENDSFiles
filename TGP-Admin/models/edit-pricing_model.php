<?php 
 
class EditPricingModel{
 
    public function getTable($table, $opt=null){
        if($table == 2){
            //Declare all the Live table here
            $Table = 'productsPricing';
            $pc = 'productsCurrent';
            $cmsTrackTable = 'CMSeditPageTracker';
        }else{
            //Declare all the Dev table here
            $Table = 'productsPricingDEV';
            $pc = 'productsCurrentDEV';
            $cmsTrackTable = 'CMSeditPageTracker';
        } 
        if($opt != null){
            if($opt == 2){
                $Table = $pc;
            }
            if($opt == 5){
                $Table = $cmsTrackTable;
            }
        }
        return $Table;
     }
     public function selectPricing($table){    
        
        $table = $this->getTable($table);   
         
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT '.$table.'.index, Coode, Naame, Currency FROM  '.$table.' ORDER BY Coode ASC '); 
        foreach($req->fetchAll() as $post) {
            $list[] =  $post;
        } 
        return $list;
     }

     
     //Select ID 
     public function selectPricingID($id, $table){    
        $conn = Db::getInstance();
        $table = $this->getTable($table);   
        $req = $conn->query("SELECT * FROM ".$table." WHERE index =  :id "); 
        $req->execute(array('id' => $id));
        $results = $req->fetch();
        return $results;
     }

     public function selectCode($table, $opt){   
        $table = $this->getTable($table, $opt);    
        $conn = Db::getInstance();
        $req = $conn->query('SELECT Code FROM  '.$table.' ORDER BY Code ASC '); 
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