<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/categories.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to add categories.";
    header("Location: ../../pages/categories.php");
    exit;
}

$category = trim($_POST['category']);
$_SESSION['oldCategory'] = $category;

if (empty($category)) {
    $_SESSION['categoryError'] = "Category is empty!";
    header("Location: ../../pages/categories/add.php");
    exit;
}

try {
    $checkStmt = $pdo->prepare("SELECT tcid FROM toycategories WHERE category = ?");
    $checkStmt->execute([$category]);

    if ($checkStmt->fetch()) {
        $_SESSION['categoryError'] = "Category Already Exists.";
        header("Location: ../../pages/categories/add.php");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO toycategories (category) VALUES (?)");
    $stmt->execute([$category]);

    $_SESSION['success'] = "Category Added Successfully.";
    unset($_SESSION['oldCategory']);

    header("Location: ../../pages/categories/add.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/categories/add.php");
    exit;
}