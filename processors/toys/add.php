<?php
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/toys.php");
    exit;
}

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'staff')) {
    $_SESSION['error'] = "You do not have the permission to add a Toy.";
    header("Location: ../../pages/toys.php");
    exit;
}

$name = trim($_POST['name']);
$description = trim($_POST['description']);
$min = trim($_POST['min']);
$max = trim($_POST['max']);
$price = $_POST['price'];
$stock = $_POST['stock'];
$category = $_POST['category'];
$type = $_POST['type'];
$brand = $_POST['brand'];

$hasError = false;

$_SESSION['oldName'] = $name;
$_SESSION['oldDescription'] = $description;
$_SESSION['oldMin'] = $min;
$_SESSION['oldMax'] = $max;
$_SESSION['oldPrice'] = $price;
$_SESSION['oldStock'] = $stock;
$_SESSION['oldCategory'] = $category;
$_SESSION['oldType'] = $type;
$_SESSION['oldBrand'] = $brand;

if (empty($name)) {
    $_SESSION['nameError'] = "Full Name is empty!";
    $hasError = true;
}

if (empty($description)) {
    $_SESSION['descriptionError'] = "description Address is empty!";
    $hasError = true;
}


if (empty($min)) {
    $_SESSION['minError'] = "Min is empty!";
    $hasError = true;
}

if (empty($max)) {
    $_SESSION['maxError'] = "Max is empty!";
    $hasError = true;
}

if (empty($price)) {
    $_SESSION['priceError'] = "price Address is empty!";
    $hasError = true;
}

if (empty($stock)) {
    $_SESSION['stockError'] = "stock # is empty!";
    $hasError = true;
}

if (empty($category)) {
    $_SESSION['categoryError'] = "Category is empty!";
    $hasError = true;
}

if (empty($type)) {
    $_SESSION['typeError'] = "Toy Type is empty!";
    $hasError = true;
}

if (empty($brand)) {
    $_SESSION['brandError'] = "Brand is empty!";
    $hasError = true;
}

if ($hasError) {
    $_SESSION['error'] = "Input error!";
    header("Location: ../../pages/toys/add.php");
    exit;
}


try {
    $check = $pdo->prepare("SELECT * FROM toys WHERE name = :name");
    $check->execute([":name" => $name]);
    $result = $check->fetch();

    if ($result) {
        $_SESSION['error'] = "Toy already exists!";
        header("Location: ../../pages/toys/add.php");
        exit;
    }

    $file = $_FILES['image'];

    if (!empty($file['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $_SESSION['pfpError'] = "Only JPG, JPEG, PNG, WEBP allowed.";
            header("Location: ../../pages/create-profile.php");
            exit;
        }

        $uploadDir = "../../storage/images/toys/";

        $newName = "toy_" . "_" . time() . "." . $ext;
        $targetPath = $uploadDir . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $stmt = $pdo->prepare("INSERT INTO toys (name, description, min_age, max_age, price, stock, imagepath, aid, tcid, ttid, bid) VALUES (:name, :description, :min_age, :max_age, :price, :stock, :imagepath, :aid, :tcid, :ttid, :bid)");
            $stmt->execute([
                
                ":name" => $name,
                ":description" => $description, 
                ":min_age" => $min, 
                ":max_age" => $max,
                ":price" => $price, 
                ":stock" => $stock,
                ":imagepath" => $newName,
                ":aid" => $_SESSION['aid'],
                ":tcid" => $category,
                ":ttid" => $type,
                ":bid" => $brand,
            ]);
        }
    }    
    else {
        $stmt = $pdo->prepare("INSERT INTO toys (name, description, min_age, max_age, price, stock, aid, tcid, ttid, bid) VALUES (:name, :description, :min_age, :max_age, :price, :stock, :aid, :tcid, :ttid, :bid)");
        $stmt->execute([
            ":name" => $name,
            ":description" => $description, 
            ":min_age" => $min, 
            ":max_age" => $max,
            ":price" => $price, 
            ":stock" => $stock,
            ":aid" => $_SESSION['aid'],
            ":tcid" => $category,
            ":ttid" => $type,
            ":bid" => $brand,
        ]);
    }

    
    
    $_SESSION['success'] = "Toy Added Successfully";

    unset($_SESSION['oldName']);
    unset($_SESSION['oldDescription']);
    unset($_SESSION['oldMin']);
    unset($_SESSION['oldMax']);
    unset($_SESSION['oldPrice']);
    unset($_SESSION['oldStock']);
    unset($_SESSION['oldCategory']);
    unset($_SESSION['oldType']);
    unset($_SESSION['oldBrand']);

    header("Location: ../../pages/toys/add.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/toys/add.php");
    exit;
}