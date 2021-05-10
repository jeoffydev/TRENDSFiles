<?php 
 

function  TrackingManagerModel(){
    $TrackingManagerModel = new TrackingManagerModel(); 
    return $TrackingManagerModel;
}

function sample($itemCode, $table){ 
    $TrackingManagerModel = new TrackingManagerModel(); 
    $results = $TrackingManagerModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $TrackingManagerModel = new TrackingManagerModel(); 
    $results = $TrackingManagerModel->selectProductsCurrent($table);
    return $results;
}
   
 
function getTheTable($table){
    $TrackingManagerModel = new TrackingManagerModel(); 
    $results = $TrackingManagerModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $TrackingManagerModel = new TrackingManagerModel(); 
    $results = $TrackingManagerModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $TrackingManagerModel = new TrackingManagerModel(); 
    $results = $TrackingManagerModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $TrackingManagerModel = new TrackingManagerModel(); 
    $results = $TrackingManagerModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}





?>