<?php 
 

function  ImageManagerModel(){
    $ImageManagerModel = new ImageManagerModel(); 
    return $ImageManagerModel;
}

function sample($itemCode, $table){ 
    $ImageManagerModel =  ImageManagerModel();
    $results = $ImageManagerModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $ImageManagerModel =  ImageManagerModel();
    $results = $ImageManagerModel->selectProductsCurrent($table);
    return $results;
}
   
 

function getTheTable($table){
    $ImageManagerModel =  ImageManagerModel();
    $results = $ImageManagerModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $ImageManagerModel =  ImageManagerModel();
    $results = $ImageManagerModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $ImageManagerModel =  ImageManagerModel();
    $results = $ImageManagerModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $ImageManagerModel =  ImageManagerModel();
    $results = $ImageManagerModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}

?>