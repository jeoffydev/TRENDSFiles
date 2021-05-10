<?php 
 

function  FileUploaderModel(){
    $FileUploaderModel = new FileUploaderModel(); 
    return $FileUploaderModel;
}

function sample($itemCode, $table){ 
    $FileUploaderModel = new FileUploaderModel(); 
    $results = $FileUploaderModel->selectProductID($itemCode, $table);
    return $results;
} 

function getProducts($table){
    $FileUploaderModel = new FileUploaderModel(); 
    $results = $FileUploaderModel->selectProductsCurrent($table);
    return $results;
}
   
 
function getTheTable($table){
    $FileUploaderModel = new FileUploaderModel(); 
    $results = $FileUploaderModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $FileUploaderModel = new FileUploaderModel(); 
    $results = $FileUploaderModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $FileUploaderModel = new FileUploaderModel(); 
    $results = $FileUploaderModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $FileUploaderModel = new FileUploaderModel(); 
    $results = $FileUploaderModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}





?>