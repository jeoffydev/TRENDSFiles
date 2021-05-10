<?php 
 

function  BrandingManagerModel(){
    $BrandingManagerModel = new BrandingManagerModel(); 
    return $BrandingManagerModel;
}

function sample($itemCode, $table){ 
    $BrandingManagerModel =  BrandingManagerModel();
    $results = $BrandingManagerModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $BrandingManagerModel =  BrandingManagerModel();
    $results = $BrandingManagerModel->selectProductsCurrent($table);
    return $results;
}
   
 

function getTheTable($table){
    $BrandingManagerModel =  BrandingManagerModel();
    $results = $BrandingManagerModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $BrandingManagerModel =  BrandingManagerModel();
    $results = $BrandingManagerModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $BrandingManagerModel =  BrandingManagerModel();
    $results = $BrandingManagerModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $BrandingManagerModel =  BrandingManagerModel();
    $results = $BrandingManagerModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}

?>