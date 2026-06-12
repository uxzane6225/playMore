<?php
$host = "localhost";
$port = 3307;
$user = "root";
$pass = "";
$dbname = "playMore";

$dsn = "mysql:host=$host;port:$port;dbname=$dbname;charset=utf-8";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    header("Location: errorPage.php");
    exit;
}