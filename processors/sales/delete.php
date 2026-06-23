<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/sales.php");
    exit;
}

if (!isset($_SESSION['role']) ||  $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to delete sales.";
    header("Location: ../../pages/sales.php");
    exit;
}

$sid = $_POST['delete'] ?? 0;

if (!is_numeric($sid) || $sid <= 0) {
    $_SESSION['error'] = "Invalid Sale selected.";
    header("Location: ../../pages/sales.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM sales WHERE sid = ?");
    $stmt->execute([$sid]);

    $_SESSION['success'] = "Sale Deleted Successfully.";

    header("Location: ../../pages/sales.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/sales.php");
    exit;
}
