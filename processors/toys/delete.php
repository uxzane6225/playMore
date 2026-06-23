<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/toys.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to delete toys.";
    header("Location: ../../pages/toys.php");
    exit;
}

$tid = $_POST['delete'] ?? 0;

if (!is_numeric($tid) || $tid <= 0) {
    $_SESSION['error'] = "Invalid toy selected.";
    header("Location: ../../pages/toys.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM toys WHERE tid = ?");
    $stmt->execute([$tid]);

    $_SESSION['success'] = "Toy Deleted Successfully.";

    header("Location: ../../pages/toys.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/toys.php");
    exit;
}
