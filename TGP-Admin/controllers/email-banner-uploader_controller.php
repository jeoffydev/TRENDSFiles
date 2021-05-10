<?php 
 

function  EmailBannerUploaderModel(){
    $EmailBannerUploaderModel = new EmailBannerUploaderModel(); 
    return $EmailBannerUploaderModel;
}

function sample($itemCode, $table){ 
    $EmailBannerUploaderModel = new EmailBannerUploaderModel(); 
    $results = $EmailBannerUploaderModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $EmailBannerUploaderModel = new EmailBannerUploaderModel(); 
    $results = $EmailBannerUploaderModel->selectProductsCurrent($table);
    return $results;
}
   
 
function getTheTable($table){
    $EmailBannerUploaderModel = new EmailBannerUploaderModel(); 
    $results = $EmailBannerUploaderModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $EmailBannerUploaderModel = new EmailBannerUploaderModel(); 
    $results = $EmailBannerUploaderModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $EmailBannerUploaderModel = new EmailBannerUploaderModel(); 
    $results = $EmailBannerUploaderModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $EmailBannerUploaderModel = new EmailBannerUploaderModel(); 
    $results = $EmailBannerUploaderModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}





?>