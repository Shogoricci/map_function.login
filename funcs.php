<?php
// XSS対策
function h($str) { return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }

// DB接続
function db_conn() {
    try {
        $db_name = "shogoritchiito_sakurabase";
        $db_host = "mysql3112.db.sakura.ne.jp";
        $db_id   = "shogoritchiito_sakurabase"; // あなたのID
        $db_pw   = "Shogo1393";           // あなたのパスワード
        
        $pdo = new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
        // エラーを表示する設定を追加
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}

// ログインチェック
function loginCheck() {
    if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
        header("Location: login.php");
        exit();
    } else {
        session_regenerate_id(true);
        $_SESSION["chk_ssid"] = session_id();
    }
}

function sql_error($stmt) {
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

function redirect($file_name) {
    header("Location: ".$file_name);
    exit();
}