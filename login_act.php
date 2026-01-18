<?php
session_start();
include("funcs.php");

$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

$pdo = db_conn();

$stmt = $pdo->prepare("SELECT * FROM map_login WHERE lid = :lid AND life_flg=0");
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){ sql_error($stmt); }
$val = $stmt->fetch();

// 該当ユーザーがいればパスワードを照合
if( $val["id"] != "" && password_verify($lpw, $val["lpw"]) ){
    $_SESSION["chk_ssid"]  = session_id();
    $_SESSION["u_id"]      = $val['id']; // 重要：自分のID
    $_SESSION["name"]      = $val['name'];
    redirect("select.php");
} else {
    // 失敗したらログインに戻る
    redirect("login.php");
}