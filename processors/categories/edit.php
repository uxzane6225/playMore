<?php
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/categories.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to edit categories.";
    header("Location: ../../pages/categories.php");
    exit;
}

$category = trim($_POST['category']);
$tcid = $_SESSION['tcid'] ?? 0;

if (empty($category)) {
    $_SESSION['categoryError'] = "Category is empty!";
    header("Location: ../../pages/categories/edit.php?tcid={$tcid}");
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE toycategories SET category = ? WHERE tcid = ?");
    $stmt->execute([$category, $tcid]);

    $_SESSION['success'] = "Category Updated Successfully.";

    header("Location: ../../pages/categories/edit.php?tcid={$tcid}");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/categories/edit.php?tcid={$tcid}");
    exit;
}