<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/sales.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    $_SESSION['error'] = "You do not have the permission to delete sale detail.";
    header("Location: ../../pages/sales.php");
    exit;
}

$sdid = $_POST['delete'] ?? 0;

if (!is_numeric($sdid) || $sdid <= 0) {
    $_SESSION['error'] = "Invalid Sale Detail Selected.";
    header("Location: ../../pages/sales.php");
    exit;
}

try {
    $getDetail = $pdo->prepare('SELECT * FROM sale_details WHERE sdid = ?');
    $getDetail->execute([$sdid]);
    $detail = $getDetail->fetch(PDO::FETCH_ASSOC);

    $product = $detail['tid'];
    $sid = $detail['sid'];
    $quantity = $detail['quantity'];
    $total = $detail['total'];

    $getToy = $pdo->prepare('SELECT * FROM toys WHERE tid = ?');
    $getToy->execute([$product]);
    $toy = $getToy->fetch(PDO::FETCH_ASSOC);

    $stock = $toy['stock'];
    $newStock = $stock + $quantity;

    $getSale = $pdo->prepare('SELECT * FROM sales WHERE sid = ?');
    $getSale->execute([$sid]);
    $sale = $getSale->fetch(PDO::FETCH_ASSOC);

    $total_cost = $sale['total_cost'];

    $new_total_cost = $total_cost - $total;


    $stmt = $pdo->prepare("UPDATE toys SET stock = ? WHERE tid = ?");
    $stmt->execute([$newStock , $product]);

    $stmt = $pdo->prepare("UPDATE sales SET total_cost = ? WHERE sid = ?");
    $stmt->execute([$new_total_cost , $sid]);

    $stmt = $pdo->prepare("DELETE FROM sale_details WHERE sdid = ?");
    $stmt->execute([$sdid]);

    $_SESSION['success'] = "Sale Detail Deleted Successfully.";

    header("Location: ../../pages/details.php?sid=" . $sid);
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/details.php?sid=" . $sid);
    exit;
}
