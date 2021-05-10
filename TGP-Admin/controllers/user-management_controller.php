<?php 

function  UserModel(){
    $UserModel = new UserModel(); 
    return $UserModel;
} 

function getProducts($table){
    $UserModel =  UserModel();
    $results = $UserModel->selectProductsCurrent($table);
    return $results;
}
 
function getCustomerData($table){
    $UserModel =  UserModel();
    $results = $UserModel->getCustomerData($table);
    return $results;
}

function getUserData($table){
    $UserModel =  UserModel();
    $results = $UserModel->getUserData($table);
    return $results;
}

function getCurrencyData($table){
    $UserModel =  UserModel();
    $results = $UserModel->getCurrencyData($table);
    return $results;
}

function getCustomerDataNo($table){
    $UserModel =  UserModel();
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
    $UserModel =  UserModel();
    $results = $UserModel->detectUserID($table, $userID);
    return $results;
}


function detectDeleteUserID($table, $userID){
    $UserModel =  UserModel();
    $results = $UserModel->detectDeleteUserID($table, $userID);
    return $results;
}


//Cache for userDatas
/*
function getJson($userDatas) {
    // cache files are created like cache/abcdef123456...
    $cacheFile = 'cache/array.json';

    if (file_exists($cacheFile)) {
        $fh = fopen($cacheFile, 'r');
        $cacheTime = trim(fgets($fh));

        // if data was cached recently, return cached data
        if ($cacheTime > strtotime('-2 minutes')) {
            return fread($fh);
        }

        // else delete cache file
        fclose($fh);
        unlink($cacheFile);
    }

    $json = $userDatas;

    $fh = fopen($cacheFile, 'w');
    fwrite($fh, time() . "\n");
    fwrite($fh, $json);
    fclose($fh);

    return $json;
} */

?>