<?php 
 

function  ComplianceManagerModel(){
    $ComplianceManagerModel = new ComplianceManagerModel(); 
    return $ComplianceManagerModel;
}

function sample($itemCode, $table){ 
    $ComplianceManagerModel =  ComplianceManagerModel();
    $results = $ComplianceManagerModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $ComplianceManagerModel =  ComplianceManagerModel();
    $results = $ComplianceManagerModel->selectProductsCurrent($table);
    return $results;
}
   
 

function getTheTable($table){
    $ComplianceManagerModel =  ComplianceManagerModel();
    $results = $ComplianceManagerModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $ComplianceManagerModel =  ComplianceManagerModel();
    $results = $ComplianceManagerModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $ComplianceManagerModel =  ComplianceManagerModel();
    $results = $ComplianceManagerModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $ComplianceManagerModel =  ComplianceManagerModel();
    $results = $ComplianceManagerModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}

?>