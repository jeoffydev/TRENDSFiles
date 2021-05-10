<?php 
/*
#This is the filter class
*/
class ProductsCurrent{

    //Declare properties  
    //private $Table = 'productsCurrent';
    //private $TableDev = 'productsCurrentDEV';
    //private $Table= 'productsCurrent';

   /* public function __construct($Table) {
        $this->$Table = $Table; 
        if($this->$Table == 2){
            $this->$Table = 'productsCurrent';
        }else{
            $this->$Table = 'productsCurrentDEV';
        } 
        
     } */
     
     public function getTable($table){
        if($table == 2){
            $Table = 'productsCurrent';
        }else{
            $Table = 'productsCurrentDEV';
        }
        
        return $Table;
     }
    
     //Select ID 
     public function selectProductID($conn, $id, $table){    
        $table = $this->getTable($table);  
        $query = $conn->prepare("SELECT * FROM ".$table." WHERE Prim = ".$id."");
        $query->execute(); 
        $results = $query->fetchAll(PDO::FETCH_ASSOC); 
        return $results;
     }


}


?>