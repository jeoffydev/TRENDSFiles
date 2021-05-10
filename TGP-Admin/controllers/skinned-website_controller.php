<?php 

function  SkinnedModel(){
    $SkinnedModel = new SkinnedModel(); 
    return $SkinnedModel;
} 

function getProducts($table){
    $SkinnedModel =  SkinnedModel();
    $results = $SkinnedModel->selectProductsCurrent($table);
    return $results;
}
 
function getCustomerData($table){
    $SkinnedModel =  SkinnedModel();
    $results = $SkinnedModel->getCustomerData($table);
    return $results;
}

function getCustomerDataNo($table){
    $SkinnedModel =  SkinnedModel();
    $results = $SkinnedModel->getCustomerDataNo($table);
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
    $SkinnedModel =  SkinnedModel();
    $results = $SkinnedModel->detectUserID($table, $userID);
    return $results;
}


function detectDeleteUserID($table, $userID){
    $SkinnedModel =  SkinnedModel();
    $results = $SkinnedModel->detectDeleteUserID($table, $userID);
    return $results;
}


?>