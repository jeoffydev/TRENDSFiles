<?php 
 

function  AddProductModel(){
    $AddProductModel = new AddProductModel(); 
    return $AddProductModel;
}

function getProductsBeta($table){
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->selectProductsCurrentBeta($table);
    return $results;
}

function sample($itemCode, $table){ 
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->selectProductsCurrent($table);
    return $results;
}
   

function getCategories($table){
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->selectCategories($table);
    return $results;
}

function getSubCategories($table, $subCat){
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->selectSubCategories($table, $subCat);
    return $results;
}

 

function getTheTable($table){
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $AddProductModel =  AddProductModel();
    $results = $AddProductModel->detectDeleteUserID($table, $userID);
    return $results;
}



function testing(){
    echo "Testing";
}

?>