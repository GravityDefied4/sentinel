<?php
    header("Content-Type: application/json");
    require '../../vendor/autoload.php';

    use Rootscratch\PSGC\PSGC;

    $psgcApi = new PSGC();

    $type = $_GET['type'] ?? null;

    try {
        switch ($type) {

            // GET ALL REGIONS
            case 'regions':
                $regions = $psgcApi->Regions();
                echo json_encode($regions, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                break;

            // GET ALL PROVINCES
            case 'provinces':
                $provinces = $psgcApi->Provinces();
                echo json_encode($provinces, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                break;

            // GET CITIES BY REGION (for NCR and other province-less regions)
            case 'cities':
                $regionCode = $_GET['region'] ?? null;
                $cities = $psgcApi->Cities();
                if ($regionCode) {
                    $prefix = substr($regionCode, 0, 2);
                    $cities = array_values(array_filter($cities, function($city) use ($prefix) {
                        return substr($city['psgc_id'], 0, 2) === $prefix;
                    }));
                }
                echo json_encode($cities, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                break;

            // INVALID TYPE
            default:
                echo json_encode([
                    "error" => "Invalid type parameter"
                ]);
        }

    } catch (Exception $e) {
        echo json_encode([
            "error" => $e->getMessage()
        ]);
    }
?>