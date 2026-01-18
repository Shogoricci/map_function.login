<?php
session_start();
include("funcs.php");
loginCheck(); // ログインしてないと見れない
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>地図登録</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body { background: #050a0f; color: #fff; text-align: center; font-family: sans-serif; }
        #map { width: 80%; height: 400px; margin: 20px auto; border: 2px solid #00f2ff; }
        form { background: #161b22; padding: 20px; display: inline-block; width: 400px; text-align: left; }
        input, textarea { width: 100%; margin-bottom: 10px; background: #000; color: #fff; border: 1px solid #444; }
    </style>
</head>
<body>
    <h1>📍 MAP DEPLOY</h1>
    <p>ようこそ <?=h($_SESSION["name"])?> さん | <a href="select.php" style="color:#00f2ff;">データ一覧を見る</a> | <a href="logout.php" style="color:red;">ログアウト</a></p>
    
    <div id="map"></div>

    <form method="POST" action="insert.php">
        地点名：<input type="text" name="name" required>
        緯度：<input type="text" name="lat" id="lat" readonly>
        経度：<input type="text" name="lng" id="lng" readonly>
        コメント：<textarea name="naiyou" rows="4"></textarea>
        <input type="submit" value="登録する" style="background:#00f2ff; color:#000; font-weight:bold; cursor:pointer; padding:10px;">
    </form>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([35.6895, 139.6917], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        map.on('click', function(e) {
            document.getElementById('lat').value = e.latlng.lat.toFixed(8);
            document.getElementById('lng').value = e.latlng.lng.toFixed(8);
        });
    </script>
</body>
</html>