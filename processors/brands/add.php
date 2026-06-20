<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../brands/brands.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to add brands.";
    header("Location: ../../pages/brands.php");
    exit;
}

$brand = trim($_POST['brand']);
$_SESSION['oldBrand'] = $brand;

if (empty($brand)) {
    $_SESSION['brandError'] = "Brand is empty!";
    header("Location: ../../pages/brands/add.php");
    exit;
}

try {

    $checkStmt = $pdo->prepare("SELECT bid FROM brands WHERE brand = ?");
    $checkStmt->execute([$brand]);

    if ($checkStmt->fetch()) {
        $_SESSION['brandError'] = "Brand Already Exists.";
        header("Location: ../../pages/brands/add.php");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO brands (brand) VALUES (?)");
    $stmt->execute([$brand]);

    $_SESSION['success'] = "Brand Added Successfully.";
    unset($_SESSION['oldBrand']);

    header("Location: ../../pages/brands/add.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/brands/add.php");
    exit;
}