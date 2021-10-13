<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\Ibge\Ibge;

try {
    $ibge = new Ibge();
    
    //retorna JSON
    $resp = $ibge->cidades('16')->get();
    
    //retorna ARRAY
    //$resp = $ibge->cidades('16')->toArray();
    
    //retorna stdClass
    //$resp = $ibge->cidades('16')->toStd();
    
    //retorna CSV
    //$resp = $ibge->cidades('16')->toCSV();
    
    //retorna SQL
    //$resp = $ibge->cidades('16')->toSQL();
    
    echo "<pre>";
    print_r($resp);
    echo "</pre>";
} catch (\Exception $e) {
    echo $e->getMessage();
}