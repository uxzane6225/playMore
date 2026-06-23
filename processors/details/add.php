<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/sales.php");
    exit;
}

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    $_SESSION['error'] = "You do not have the permission to add details.";
    header("Location: ../../pages/sales.php");
    exit;
}

$sid = $_POST['sid'];
$product = trim($_POST['product']);
$quantity = $_POST['quantity'];

$_SESSION['oldProduct'] = $product;
$_SESSION['oldQuantity'] = $quantity;

$hasError = false;

if (empty($sid)) {
    $_SESSION['error'] = "You do not have the Sale ID!";
    header("Location: ../../pages/sales.php?");
    exit;
}

if (empty($product)) {
    $_SESSION['customerError'] = "Product is empty!";
    $hasError = true;
}

if (empty($quantity) || $quantity < 1) {
    $_SESSION['totalError'] = "Quantity is empty!";
    $hasError = true;
}

if ($hasError) {
    header("Location: ../../pages/details/add.php?sid=" . $sid);
    exit;
}

try {
    $getToy = $pdo->prepare('SELECT * FROM toys WHERE tid = ?');
    $getToy->execute([$product]);
    $toy = $getToy->fetch(PDO::FETCH_ASSOC);
    $stock = $toy['stock'];
    $price = $toy['price'];

    $total = $price * $quantity;

    if ($stock < $quantity) {
        $_SESSION['error'] = "Quantity exceeds available stock!";
        header("Location: ../../pages/details/add.php?sid=" . $sid);
        exit;
    }

    $newStock = $stock - $quantity;

    $stmt = $pdo->prepare('UPDATE toys SET stock = ? WHERE tid = ?');
    $stmt->execute([$newStock, $product]);

    $getSale = $pdo->prepare('SELECT * FROM sales WHERE sid = ?');
    $getSale->execute([$sid]);
    $sale = $getSale->fetch(PDO::FETCH_ASSOC);

    $total_cost = $sale['total_cost'];
    $newTotal_cost = $total_cost + $total;

    $stmt = $pdo->prepare('UPDATE sales SET total_cost = ? WHERE sid = ?');
    $stmt->execute([$newTotal_cost, $sid]);

    $stmt = $pdo->prepare("INSERT INTO sale_details (tid, sid, quantity, total) VALUES (?, ?, ?, ?)");
    $stmt->execute([$product, $sid, $quantity, $total]);


    $_SESSION['success'] = "Details Added Successfully.";
    unset($_SESSION['oldProduct']);
    unset($_SESSION['oldQuantity']);

    header("Location: ../../pages/details/add.php?sid=" . $sid);
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/details/add.php?sid=" . $sid);
    exit;
}