<?php
// 1. エラー表示を有効にする
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. セッション開始
session_start();

// 3. 共通関数の読み込み
include("funcs.php");

// 4. ログインチェック
loginCheck();

// 5. 変数の取得
$u_id = $_SESSION["u_id"]; // ログイン時に保存した自分のID
$pdo = db_conn();

// 6. データ取得SQL（地点データが保存されている gs_bm_table から取得）
// テーブル名にハイフンは使えません。アンダーバーの gs_bm_table を指定してください
$sql = "SELECT * FROM gs_bm_table WHERE u_id = :u_id ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
$status = $stmt->execute();

// 7. データ表示の準備
$view = ""; 
$locations = [];

if($status==false) {
    // SQL実行エラーの場合
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
} else {
    // 正常に取得できた場合、ループでHTMLを作成
    while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
        $view .= '<div style="background:#161b22; padding:15px; border-left:5px solid #00f2ff; margin-bottom:10px; border-radius:5px;">';
        $view .= '<h3>'.h($r["name"]).'</h3>';
        $view .= '<p>'.h($r["naiyou"]).'</p>';
        $view .= '<a href="detail.php?id='.$r["id"].'" style="color:#ffea00;">[編集]</a> ';
        $view .= '<a href="delete.php?id='.$r["id"].'" style="color:#ff3333;" onclick="return confirm(\'削除しますか？\')">[削除]</a>';
        $view .= '</div>';
        
        // 地図表示用の配列に格納
        $locations[] = $r;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
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
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h1>📍 MY MAP LIST</h1>
        <div>
            <span>USER: <?=h($_SESSION["name"])?></span> | 
            <a href="index.php" style="border:1px solid #00f2ff; padding:5px;">地点を登録する</a> | 
            <a href="logout.php" style="color:red;">ログアウト</a>
        </div>
    </div>

    <!-- 地図を表示する場所 -->
    <div id="map"></div>

    <!-- カード一覧を表示する場所 -->
    <div class="grid"><?= $view ?></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // 地図の初期化（日本全体が見えるように設定）
        const map = L.map('map').setView([36.2048, 138.2529], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // PHPから受け取った地点データをJavaScriptの配列にする
        const data = <?= json_encode($locations) ?>;

        // 配列をループして地図にピン（マーカー）を立てる
        data.forEach(l => {
            if(l.lat && l.lng) {
                L.marker([l.lat, l.lng]).addTo(map).bindPopup(`<b>${l.name}</b><br>${l.naiyou}`);
            }
        });
    </script>
</body>
</html>