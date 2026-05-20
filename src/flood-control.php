<?php
    require 'psgc.php';
    header("Content-Type: application/json");

    // $url = "https://psgc.rootscratch.com/barangay?id=0105518000";
    // $url = "https://psgc.rootscratch.com/barangay?id=0105526000";
    // $url = "https://psgc.rootscratch.com/barangay?id=0105526011";
    $url = "https://raw.githubusercontent.com/bettergovph/bettergov/refs/heads/main/src/data/flood_control/flood_control.json";
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if ($response === false) {
        echo json_encode([
            "error" => "API not responding: " . curl_error($ch)
        ]);
        curl_close($ch);
        exit;
    }

    $httpCode=curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode != 200) {
        echo json_encode([
            "error" => "API returned status code: " . $httpCode
        ]);
        exit;
    }

    $n = 0;
    $data = json_decode($response, true);
    $project = $data["features"];
    $count = 0;
    
    while ($n < count($project)) {
        if ($project[$n]["attributes"]["Region"] == $psgcRegion) {
            echo json_encode($project[$n], JSON_PRETTY_PRINT);
            $count++;
        }
        $n++;
    }
    echo "Total number of Region I projects: " . $count;
    echo "Total number of PH Projects: " . count($project);
?>