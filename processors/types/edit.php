<?php
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/types.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to edit toy types.";
    header("Location: ../../pages/types.php");
    exit;
}

$type = trim($_POST['type']);
$ttid = $_SESSION['ttid'] ?? 0;

if (empty($type)) {
    $_SESSION['brandError'] = "Toy Type is empty!";
    header("Location: ../../pages/types/edit.php?ttid={$ttid}");
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE toytypes SET type = ? WHERE ttid = ?");
    $stmt->execute([$type, $ttid]);

    $_SESSION['success'] = "Toy Type Updated Successfully.";

    header("Location: ../../pages/types/edit.php?ttid={$ttid}");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/types/edit.php?ttid={$ttid}");
    exit;
}