<?php 

 

function  EditPricingModel(){
    $EditPricingModel = new EditPricingModel(); 
    return $EditPricingModel;
}

function sample($itemCode, $table){ 
    $EditPricingModel =  EditPricingModel();
    $results = $EditPricingModel->selectPricingID($itemCode, $table);
    return $results;
} 

function getPricing($table){
    $EditPricingModel =  EditPricingModel();
    $results = $EditPricingModel->selectPricing($table);
    return $results;
}
   
function getCurrency(){
    $currency = array('0' => 'NZD',  '1'=> 'AUD');
    return $currency;
}

function getCode($table, $opt){
    $EditPricingModel =  EditPricingModel();
    $results = $EditPricingModel->selectCode($table, $opt);
    return $results;
}
 
function getTheTable($table){
    $EditPricingModel =  EditPricingModel();
    $results = $EditPricingModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $EditPricingModel =  EditPricingModel();
    $results = $EditPricingModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $EditPricingModel =  EditPricingModel();
    $results = $EditPricingModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $EditPricingModel =  EditPricingModel();
    $results = $EditPricingModel->detectDeleteUserID($table, $userID);
    return $results;
}

?>