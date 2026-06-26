<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/types.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to Delete a Toy Type.";
    header("Location: ../../pages/types.php");
    exit;
}

$ttid = $_POST['delete'] ?? 0;

if (!is_numeric($ttid) || $ttid <= 0) {
    $_SESSION['error'] = "Invalid toy type selected.";
    header("Location: ../../pages/types.php");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM toytypes WHERE ttid = ?");
    $stmt->execute([$ttid]);

    $_SESSION['success'] = "Toy Type Deleted Successfully.";

    header("Location: ../../pages/types.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/types.php");
    exit;
}
