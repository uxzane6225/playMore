<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/categories.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to delete categories.";
    header("Location: ../../pages/categories.php");
    exit;
}

$tcid = $_POST['delete'] ?? 0;

if (!is_numeric($tcid) || $tcid <= 0) {
    $_SESSION['error'] = "Invalid category selected.";
    header("Location: ../../pages/categories.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM toycategories WHERE tcid = ?");
    $stmt->execute([$tcid]);

    $_SESSION['success'] = "Category Deleted Successfully.";

    header("Location: ../../pages/categories.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/categories.php");
    exit;
}
