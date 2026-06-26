<?php
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/brands.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] == 'user') {
    $_SESSION['error'] = "You do not have the permission to Edit a Brand.";
    header("Location: ../../pages/brands.php");
    exit;
}

$brand = trim($_POST['brand']);
$bid = $_SESSION['bid'] ?? 0;

if (empty($brand)) {
    $_SESSION['brandError'] = "Brand is Empty!";
    header("Location: ../../pages/brands/edit.php?bid={$bid}");
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE brands SET brand = ? WHERE bid = ?");
    $stmt->execute([$brand, $bid]);

    $_SESSION['success'] = "Brand Updated Successfully.";

    header("Location: ../../pages/brands/edit.php?bid={$bid}");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/brands/edit.php?bid={$bid}");
    exit;
}