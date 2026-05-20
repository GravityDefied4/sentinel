<?php
    header("Content-Type: application/json");
    require 'vendor/autoload.php';

    use Rootscratch\PSGC\PSGC;

    $psgcApi = new PSGC();
    $regions = $psgcApi->Regions();
    $psgcRegion = "Region I";
    // echo json_encode($regions, JSON_PRETTY_PRINT);
?>