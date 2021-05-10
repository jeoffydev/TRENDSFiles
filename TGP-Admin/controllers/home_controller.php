<?php 

function  HomeModel(){
    $HomeModel = new HomeModel(); 
    return $HomeModel;
}

function countActiveProducts($table){
    $HomeModel =  HomeModel();
    $results = $HomeModel->countActiveProducts($table);
    return $results;
}

function countNzdPricing($table, $currency){
    $HomeModel =  HomeModel();
    $results = $HomeModel->countNzdPricing($table, $currency);
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
    $HomeModel =  HomeModel();
    $results =  $HomeModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $HomeModel =  HomeModel();
    $results =  $HomeModel->detectDeleteUserID($table, $userID);
    return $results;
}

?>