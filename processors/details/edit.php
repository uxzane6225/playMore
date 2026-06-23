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
$sdid = $_POST['sdid'];
$product = $_POST['product'];
$quantity = $_POST['quantity'];

$_SESSION['oldProduct'] = $product;
$_SESSION['oldQuantity'] = $quantity;

$hasError = false;

if (empty($sid)) {
    $_SESSION['error'] = "You do not have the Sale ID!";
    header("Location: ../../pages/sales.php?");
    exit;
}

if (empty($sdid)) {
    $_SESSION['error'] = "You do not have the Sale Details ID!";
    
    header("Location: ../../pages/sales.php?");
    exit;
}

if (empty($product)) {
    $_SESSION['productError'] = "Product is empty!";
    $hasError = true;
}

if (empty($quantity) || $quantity < 1) {
    $_SESSION['totalError'] = "Quantity is empty!";
    $hasError = true;
}

if ($hasError) {
    //echo "here 1";
    header("Location: ../../pages/details/edit.php?sdid=" . $sdid);
    //echo "The product; " . $product;
    exit;
}

try {

    $getSD = $pdo->prepare('SELECT * FROM sale_details WHERE sdid = ?');
    $getSD->execute([$sdid]);
    $SD = $getSD->fetch(PDO::FETCH_ASSOC);

    $getToy = $pdo->prepare('SELECT * FROM toys WHERE tid = ?');
    $getToy->execute([$product]);
    $toy = $getToy->fetch(PDO::FETCH_ASSOC);

    $getSale = $pdo->prepare('SELECT * FROM sales WHERE sid = ?');
    $getSale->execute([$sid]);
    $sale = $getSale->fetch(PDO::FETCH_ASSOC);

    $oldTid = $SD['tid'];
    $oldQuantity = $SD['quantity'];
    $oldTotal = $SD['total'];

    if ($oldTid != $product) {
        $_SESSIN['error'] = "Do not change the product";
        header("Location: ../../pages/details/add.php?sid=" . $sid);
        exit;
    }

    $stock = $toy['stock'];
    $price = $toy['price'];

    $difference = 0;
    $newStock = 0;

    if ($oldQuantity > $quantity) {
        $difference = $oldQuantity - $quantity;
        $newQuantity = $oldQuantity - $difference;
    }
    else if ($oldQuantity < $quantity) {
        $difference = $quantity - $oldQuantity;
        $newQuantity = $oldQuantity + $difference;
    }
    else {
        $newQuantity = $quantity; //replacement for sale_detail 'quantity'
    }

    $total = $price * $newQuantity;

    if ($stock < $difference) {
        $_SESSION['error'] = "Quantity exceeds available stock!";
        header("Location: ../../pages/details/add.php?sid=" . $sid);
        exit;
    }
    else {
        if ($oldQuantity > $quantity) {
            $newStock = $stock + $difference;
        }
        else if ($oldQuantity < $quantity) {
            $newStock = $stock - $difference;
        }
        else {
            $newStock = $stock; //replacement for toys 'stock'
        }
    }

    /*Hypothetical:
    price: 100
    old quanitity: 5
    old total = 500

    total_cost = 1000


    new quantity: 3
    new total = 300

    difference = 200

    new total cost = 800
    
    */

    $difference = 0;

    $old_total_cost = $sale['total_cost'];


    if ($oldTotal > $total) {
        $difference = $oldTotal - $total;
        $newTotal = $oldTotal - $difference;
        $new_total_cost = $old_total_cost - $difference;
    }
    else if ($oldTotal < $total) {
        $difference = $total - $oldTotal;
        $newTotal = $oldTotal + $difference;
        $new_total_cost = $old_total_cost + $difference;
    }
    else {
        $newTotal = $total; //replacement for sale_detail 'total'
        $new_total_cost = $old_total_cost; //replacement for sales 'total_cost'
    }
    

    $stmt = $pdo->prepare('UPDATE toys SET stock = ? WHERE tid = ?');
    $stmt->execute([$newStock, $product]);

    $stmt = $pdo->prepare('UPDATE sales SET total_cost = ? WHERE sid = ?');
    $stmt->execute([$new_total_cost, $sid]);

    $stmt = $pdo->prepare("UPDATE sale_details SET quantity = :quantity, total = :total WHERE sdid = :sdid");
    $stmt->execute([
        ":sdid" => $sdid,
        ":quantity" => $newQuantity,
        ":total" => $newTotal
    ]);


    $_SESSION['success'] = "Details Added Successfully.";
    unset($_SESSION['oldProduct']);
    unset($_SESSION['oldQuantity']);

    header("Location: ../../pages/details/edit.php?sdid=" . $sdid);
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/details/edit.php?sdid=" . $sdid);
    exit;
}