<?php
    $lat = isset($_GET['lat']) ? (float)$_GET['lat'] : null;
    $lon = isset($_GET['lon']) ? (float)$_GET['lon'] : null;
    $municipality = isset($_GET['municipality']) ? htmlspecialchars($_GET['municipality']) : 'Project Location';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $municipality ?></title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            html, body { height: 100%; }
            #map { height: 100vh; width: 100%; }
        </style>
    </head>
    <body>
        <div id="map"></div>
        <script>
            const lat = <?= $lat !== null ? json_encode($lat) : 'null' ?>;
            const lon = <?= $lon !== null ? json_encode($lon) : 'null' ?>;
            const municipality = <?= json_encode($municipality) ?>;

            const map = L.map('map');
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            if (lat !== null && lon !== null) {
                map.setView([lat, lon], 13);
                L.marker([lat, lon]).addTo(map)
                    .bindPopup(`<b>${municipality}</b><br>Lat: ${lat}, Lon: ${lon}`)
                    .openPopup();
            } else {
                map.setView([12.8797, 121.7740], 6);
            }
        </script>
    </body>
</html>