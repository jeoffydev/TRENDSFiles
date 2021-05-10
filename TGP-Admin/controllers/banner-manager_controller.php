<?php 
 

function  BannerManagerModel(){
    $BannerManagerModel = new BannerManagerModel(); 
    return $BannerManagerModel;
}

function sample($itemCode, $table){ 
    $BannerManagerModel = new BannerManagerModel(); 
    $results = $BannerManagerModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $BannerManagerModel = new BannerManagerModel(); 
    $results = $BannerManagerModel->selectProductsCurrent($table);
    return $results;
}
   
 
function getTheTable($table){
    $BannerManagerModel = new BannerManagerModel(); 
    $results = $BannerManagerModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $BannerManagerModel = new BannerManagerModel(); 
    $results = $BannerManagerModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $BannerManagerModel = new BannerManagerModel(); 
    $results = $BannerManagerModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $BannerManagerModel = new BannerManagerModel(); 
    $results = $BannerManagerModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}





?>