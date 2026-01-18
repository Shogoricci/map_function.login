<?php
session_start();
include("funcs.php");
loginCheck();

$pdo = db_conn();
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table ORDER BY id DESC");
$status = $stmt->execute();

$view = ""; $locations = [];
if($status==false) { sql_error($stmt); } else {
    while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= '<div style="background:#161b22; padding:15px; border-left:5px solid #00f2ff; margin-bottom:10px; border-radius:5px;">';
        $view .= '<h3>'.h($r["name"]).'</h3>';
        $view .= '<p>'.h($r["naiyou"]).'</p>';
        $view .= '<a href="detail.php?id='.$r["id"].'" style="color:#ffea00;">[編集]</a> ';
        $view .= '<a href="delete.php?id='.$r["id"].'" style="color:#ff3333;" onclick="return confirm(\'削除しますか？\')">[削除]</a>';
        $view .= '</div>';
        $locations[] = $r;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>データ一覧</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { background:#050a0f; color:#fff; font-family:sans-serif; padding:20px; }
        #map { width:100%; height:300px; margin-bottom:20px; border:1px solid #00f2ff; }
        .grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap:20px; }
        a { color:#00f2ff; text-decoration:none; }
    </style>
</head>
<body>
    <div style="display:flex; justify-content:space-between;">
        <h1>📍 DATA LIST</h1>
        <a href="index.php">登録画面に戻る</a>
    </div>
    <div id="map"></div>
    <div class="grid"><?= $view ?></div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([36.2048, 138.2529], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        const data = <?= json_encode($locations) ?>;
        data.forEach(l => {
            if(l.lat && l.lng) L.marker([l.lat, l.lng]).addTo(map).bindPopup(l.name);
        });
    </script>
</body>
</html>