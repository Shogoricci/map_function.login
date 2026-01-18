<?php
// 1. エラー表示を有効にする（デバッグ用）
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. セッション開始
session_start();

// 3. 共通関数の読み込み
include("funcs.php");

// 4. ログインチェック
loginCheck();

// 5. POSTデータ取得
$name   = $_POST["name"];
$naiyou = $_POST["naiyou"];
$lat    = $_POST["lat"];
$lng    = $_POST["lng"];
$u_id   = $_SESSION["u_id"]; // ログインしている自分のIDを取得

// 6. DB接続
$pdo = db_conn();

// 7. データ登録SQL作成
// さきほど追加した u_id を含めて、gs_bm_table に保存します
$sql = "INSERT INTO gs_bm_table(u_id, name, naiyou, lat, lng, indate) VALUES(:u_id, :name, :naiyou, :lat, :lng, sysdate())";
$stmt = $pdo->prepare($sql);

// 8. バインド変数（セキュリティ対策）
$stmt->bindValue(':u_id',   $u_id,   PDO::PARAM_INT); // 自分のID
$stmt->bindValue(':name',   $name,   PDO::PARAM_STR); // 地点名
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR); // コメント
$stmt->bindValue(':lat',    $lat,    PDO::PARAM_STR); // 緯度
$stmt->bindValue(':lng',    $lng,    PDO::PARAM_STR); // 経度

// 9. 実行
$status = $stmt->execute();

// 10. 処理後
if($status==false){
    // SQL実行エラーの場合、エラー内容を表示して止める
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
} else {
    // 成功したら一覧画面(select.php)へリダイレクト
    header("Location: select.php");
    exit();
}
?>