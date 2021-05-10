<?php 

function  UserBannerModel(){
    $UserModel = new UserBannerModel(); 
    return $UserModel;
} 

function getProducts($table){
    $UserModel =  UserBannerModel();
    $results = $UserModel->selectProductsCurrent($table);
    return $results;
}
 
function getCustomerData($table){
    $UserModel =  UserBannerModel();
    $results = $UserModel->getCustomerData($table);
    return $results;
}

function getCustomerDataNo($table){
    $UserModel =  UserBannerModel();
    $results = $UserModel->getCustomerDataNo($table);
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
    $UserModel =  UserBannerModel();
    $results = $UserModel->detectUserID($table, $userID);
    return $results;
}


function detectDeleteUserID($table, $userID){
    $UserModel =  UserBannerModel();
    $results = $UserModel->detectDeleteUserID($table, $userID);
    return $results;
}


?>