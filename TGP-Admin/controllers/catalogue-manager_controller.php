<?php 
 

function  CatalogueManagerModel(){
    $CatalogueManagerModel = new CatalogueManagerModel(); 
    return $CatalogueManagerModel;
}

function sample($itemCode, $table){ 
    $CatalogueManagerModel = new CatalogueManagerModel(); 
    $results = $CatalogueManagerModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $CatalogueManagerModel = new CatalogueManagerModel(); 
    $results = $CatalogueManagerModel->selectProductsCurrent($table);
    return $results;
}
   
 
function getTheTable($table){
    $CatalogueManagerModel = new CatalogueManagerModel(); 
    $results = $CatalogueManagerModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $CatalogueManagerModel = new CatalogueManagerModel(); 
    $results = $CatalogueManagerModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $CatalogueManagerModel = new CatalogueManagerModel(); 
    $results = $CatalogueManagerModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $CatalogueManagerModel = new CatalogueManagerModel(); 
    $results = $CatalogueManagerModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}





?>