<?php
session_start();
include("funcs.php");
loginCheck();

$id = $_GET["id"]; // URLからid取得

$pdo = db_conn();
$stmt = $pdo->prepare("DELETE FROM gs_bm_table WHERE id = :id AND u_id = :u_id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':u_id', $_SESSION["u_id"], PDO::PARAM_INT); // 自分のデータか確認
$status = $stmt->execute();

if($status==false){ sql_error($stmt); }else{ redirect("select.php"); }