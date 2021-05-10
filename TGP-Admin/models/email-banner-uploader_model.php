<?php 
 
class EmailBannerUploaderModel{
 
    public function getTable($table, $opt=null){
        if($table == 2){
            //Declare all the Live table here
            $Table = 'productsCurrent';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $changeTypeTable = 'productChangeTypes';
            $cmsTrackTable = 'CMSeditPageTracker';
            $pdfWires = 'pdfWires';
            $dhl_status_table = 'dhl_status_table';
            $banner_table = 'bannersTrendsnz';
        }else{
            //Declare all the Dev table here
            $Table = 'productsCurrentDEV';
            $catTable = 'categoriesCurrent';
            $colourSearchTable = 'colourSearch';
            $changeTypeTable = 'productChangeTypes';
            $cmsTrackTable = 'CMSeditPageTracker';
            $pdfWires = 'pdfWires';
            $dhl_status_table = 'dhl_status_table';
            $banner_table = 'bannersDEV';
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
                $Table = $pdfWires;
            }
            if($opt == 7){
                $Table = $banner_table;
            }
        }
        return $Table;
     }
     public function selectProductsCurrent($table){    
         
        $table = $this->getTable($table, 7);   
        $list = [];
        $conn = Db::getInstance();
        $req = $conn->query('SELECT * FROM  '.$table.' WHERE location="Banners_loggedout" ORDER BY orderNum '); 

        
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