<?php 

function  FeaturedModel(){
    $FeaturedModel = new FeaturedModel(); 
    return $FeaturedModel;
} 

function getProducts($table){
    $FeaturedModel =  FeaturedModel();
    $results = $FeaturedModel->selectProductsCurrent($table);
    return $results;
}
  
function getFeaturedProducts($table){
    $FeaturedModel =  FeaturedModel();
    $results = $FeaturedModel->getFeaturedProducts($table);
    return $results;
}

function currentTable($table){
    if($table == 2){ 
        $Table = 'productsCurrent'; 
    }else{ 
        $Table = 'productsCurrentDEV'; 
    } 
    return $Table;
}

function detectUserID($table, $userID){
    $FeaturedModel =  FeaturedModel();
    $results =  $FeaturedModel->detectUserID($table, $userID);
    return $results;
}


function detectDeleteUserID($table, $userID){
    $FeaturedModel =  FeaturedModel();
    $results = $FeaturedModel->detectDeleteUserID($table, $userID);
    return $results;
}


?>