<?php 
 

function  OnDemandModel(){
    $OnDemandModel = new OnDemandModel(); 
    return $OnDemandModel;
}

 

function getCurrencyData($table){
    $OnDemandModel =  OnDemandModel();
    $results = $OnDemandModel->getCurrencyData($table);
    return $results;
}

function getProducts($table){
    $OnDemandModel =  OnDemandModel();
    $results = $OnDemandModel->selectProductsCurrent($table);
    return $results;
}
   
 

function getTheTable($table){
    $OnDemandModel =  OnDemandModel();
    $results = $OnDemandModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $OnDemandModel =  OnDemandModel();
    $results = $OnDemandModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $OnDemandModel =  OnDemandModel();
    $results = $OnDemandModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $OnDemandModel =  OnDemandModel();
    $results = $OnDemandModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}

?>