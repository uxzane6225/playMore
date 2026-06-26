<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/brands.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to Delete a Brand.";
    header("Location: ../../pages/brands.php");
    exit;
}

$bid = $_POST['delete'] ?? 0;

if (!is_numeric($bid) || $bid <= 0) {
    $_SESSION['error'] = "Invalid brand selected.";
    header("Location: ../../pages/brands.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM brands WHERE bid = ?");
    $stmt->execute([$bid]);

    $_SESSION['success'] = "Brand Deleted Successfully.";

    header("Location: ../../pages/brands.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/brands.php");
    exit;
}
