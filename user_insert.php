<?php
// エラー表示を強制する（デバッグ用）
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("funcs.php");

$name = $_POST["name"];
$lid  = $_POST["lid"];
$lpw  = $_POST["lpw"];

// パスワードを暗号化
$hlpw = password_hash($lpw, PASSWORD_DEFAULT);

$pdo = db_conn();

try {
    // 登録SQL実行（map_loginテーブル）
    $stmt = $pdo->prepare("INSERT INTO map_login(name,lid,lpw,kanri_flg,life_flg) VALUES(:name,:lid,:lpw,0,0)");
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':lid',  $lid,  PDO::PARAM_STR);
    $stmt->bindValue(':lpw',  $hlpw, PDO::PARAM_STR);
    $status = $stmt->execute();
    
    redirect("login.php");
} catch (Exception $e) {
    echo "エラー発生：" . $e->getMessage();
}