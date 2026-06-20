<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/types.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to add toy types.";
    header("Location: ../../pages/types.php");
    exit;
}

$type = trim($_POST['type']);
$_SESSION['oldType'] = $type;

if (empty($type)) {
    $_SESSION['typeError'] = "Toy Type is empty!";
    header("Location: ../../pages/types/add.php");
    exit;
}

try {

    $checkStmt = $pdo->prepare("SELECT ttid FROM toytypes WHERE type = ?");
    $checkStmt->execute([$type]);

    if ($checkStmt->fetch()) {
        $_SESSION['typeError'] = "Toy Type Already Exists.";
        header("Location: ../../pages/types/add.php");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO toytypes (type) VALUES (?)");
    $stmt->execute([$type]);

    $_SESSION['success'] = "Toy Type Added Successfully.";
    unset($_SESSION['oldType']);

    header("Location: ../../pages/types/add.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/types/add.php");
    exit;
}