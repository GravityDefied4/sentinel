<?php
    $n = 0;
    $data_pol = json_decode(file_get_contents("../data/processed/politicians.json"), true);
    $data_par = json_decode(file_get_contents("../data/processed/political_parties.json"), true);
    $politicians = $data_pol;
    $parties = $data_par;
    $id = "01K7QAKGR1M0ZHCNA4CCDPRP3S";

    while ($n < count($politicians)) {
        if ($politicians[$n]["id"] == $id) {
            echo json_encode($politicians[$n], JSON_PRETTY_PRINT) . "<br><br>"; 
        }
        $n++;
    }
    $n = 0;
    while ($n < count($parties)) {
        if ($parties[$n]["person_id"] == $id) {
            echo json_encode($parties[$n], JSON_PRETTY_PRINT) . "<br><br>";
            echo "";
        }
        $n++;
    }
?>