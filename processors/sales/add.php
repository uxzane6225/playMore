<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/sales.php");
    exit;
}

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    $_SESSION['error'] = "You do not have the permission to add Sales.";
    header("Location: ../../pages/sales.php");
    exit;
}

$customer = trim($_POST['customer']);
$total = $_POST['total'];
$_SESSION['oldCustomer'] = $customer;
$_SESSION['oldTotal'] = $total;

$hasError = false;

if (empty($customer)) {
    $_SESSION['customerError'] = "Customer is empty!";
    $hasError = true;
}

if (empty($total)) {
    $_SESSION['totalError'] = "Total is empty!";
    $hasError = true;
}

if ($hasError) {
    header("Location: ../../pages/sales/add.php");
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO sales (cid, eid, total_cost) VALUES (?, ?, ?)");
    $stmt->execute([$customer, $_SESSION['aid'],$total]);

    $_SESSION['success'] = "Sale Added Successfully.";
    unset($_SESSION['oldCustomer']);
    unset($_SESSION['oldTotal']);

    header("Location: ../../pages/sales/add.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/sales/add.php");
    exit;
}