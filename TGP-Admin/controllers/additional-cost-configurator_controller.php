<?php 

function  AdditionalCost(){
    $AdditionalCost = new AdditionalCost(); 
    return $AdditionalCost;
} 

function getComponentAPI($stockcode){
    $AdditionalCost =  AdditionalCost();
    $results = $AdditionalCost->Components($stockcode);
    return $results;
}

function getProducts($table){
    $AdditionalCost =  AdditionalCost();
    $results = $AdditionalCost->selectProductsCurrent($table);
    return $results;
}
 
function getCustomerData($table){
    $AdditionalCost =  AdditionalCost();
    $results = $AdditionalCost->getCustomerData($table);
    return $results;
}

function getUserData($table){
    $AdditionalCost =  AdditionalCost();
    $results = $AdditionalCost->getUserData($table);
    return $results;
}

function getCurrencyData($table){
    $AdditionalCost =  AdditionalCost();
    $results = $AdditionalCost->getCurrencyData($table);
    return $results;
}

function getCustomerDataNo($table){
    $AdditionalCost =  AdditionalCost();
    $results = $AdditionalCost->getCustomerDataNo($table);
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
    $AdditionalCost =  AdditionalCost();
    $results = $AdditionalCost->detectUserID($table, $userID);
    return $results;
}


function detectDeleteUserID($table, $userID){
    $AdditionalCost =  AdditionalCost();
    $results = $AdditionalCost->detectDeleteUserID($table, $userID);
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