<?php 
 

function  EditProductModel(){
    $EditProductModel = new EditProductModel(); 
    return $EditProductModel;
}

function sample($itemCode, $table){ 
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->selectProductID($itemCode, $table);
    return $results;
} 

function getCurrencyData($table){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->getCurrencyData($table);
    return $results;
}

function getProducts($table){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->selectProductsCurrent($table);
    return $results;
}
   

function getCategories($table){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->selectCategories($table);
    return $results;
}


function getDespatchLocation($table){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->selectDespatchLocations($table);
    return $results;
}

function getSubCategories($table, $subCat){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->selectSubCategories($table, $subCat);
    return $results;
}



function getColourSearch($table){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->selectColourSearch($table);
    return $results;
}


function getChangeTypes($table){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->getChangeTypes($table);
    return $results;
}

function getStatus(){
    $status = array('0' => 'Normal',  'D'=> 'Discontinued', 'N'=> 'New', 'X'=> 'Not Yet Released');
    return $status;
}

function getPrimaryPriceType(){
    $status = array('U' => "Unbranded", 'N'=>"Unbranded – no branding available", 'B'=>"Branded Price");
    return $status;
}

function getComponentAPI($stockcode){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->Components($stockcode);
    return $results;
}

function getBrandingOption(){
    $status = array(
        "0" => "Pad Print",
        "1" => "Screen Print", 
        "2" => "Engraving",
        "3" => "Rotary Digital Print",
        "4" => "Imitation Etch",
        "5" => "Resin Coated Finish",
        "6" => "Digital Transfer",
        "7" => "Sublimation",
        "8" => "Digital Print",
        "9" => "Digital Label",
        "10" => "Direct Digital",
        "11" => "Debossing",
        "12" => "Debossed",
        "13 "=> "XL Debossing",
        "14" => "Embroidery",
        "15" => "Silicone Digital Print"
    );
    return $status;
}


function getTheTable($table){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->getTheTable($table);
    return $results;
}

function checkTheTable($table, $repair){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->checkTheTable($table, $repair);
    return $results;
}

function detectUserID($table, $userID){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->detectUserID($table, $userID);
    return $results;
}

function detectDeleteUserID($table, $userID){
    $EditProductModel =  EditProductModel();
    $results = $EditProductModel->detectDeleteUserID($table, $userID);
    return $results;
}

function testing(){
    echo "Testing";
}

?>