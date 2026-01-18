<?php
session_start();
include("funcs.php");
loginCheck();

$id     = $_POST["id"];
$name   = $_POST["name"];
$email  = $_POST["email"];
$age    = $_POST["age"];
$naiyou = $_POST["naiyou"];
$lat    = $_POST["lat"];
$lng    = $_POST["lng"];

$pdo = db_conn();
$sql = "UPDATE gs_bm_table SET name=:name, email=:email, age=:age, naiyou=:naiyou, lat=:lat, lng=:lng WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',   $name,   PDO::PARAM_STR);
$stmt->bindValue(':email',  $email,  PDO::PARAM_STR);
$stmt->bindValue(':age',    $age,    PDO::PARAM_INT);
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
$stmt->bindValue(':lat',    $lat,    PDO::PARAM_STR);
$stmt->bindValue(':lng',    $lng,    PDO::PARAM_STR);
$stmt->bindValue(':id',     $id,     PDO::PARAM_INT);
$status = $stmt->execute();

if($status==false){ sql_error($stmt); }else{ redirect("select.php"); }

