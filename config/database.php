<?php
$host = "localhost";
$port = 3308;
$user = "root";
$pass = "";
$dbname = "playmoredb";

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    session_start();
    error_log($e->getMessage());
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header("Location: ../pages/error.php");
    exit;
}