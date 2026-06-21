<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/users.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to delete any User.";
    header("Location: ../../pages/users.php");
    exit;
}

$aid = $_POST['delete'] ?? 0;

if (!is_numeric($aid) || $aid <= 0) {
    $_SESSION['error'] = "Invalid brand selected.";
    header("Location: ../../pages/users.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM accounts WHERE aid = ?");
    $stmt->execute([$aid]);

    $_SESSION['success'] = "User Deleted Successfully.";

    header("Location: ../../pages/users.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/users.php");
    exit;
}
