<?php
require('../../config/database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "You do not have the permission to execute this process.";
    header("Location: ../../pages/register.php");
    exit;
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$home = trim($_POST['home']);
$phone = trim($_POST['phone']);
$password = trim($_POST['password']);
$confirm = trim($_POST['confirm']);

$hasError = false;

$_SESSION['oldName'] = $name;
$_SESSION['oldEmail'] = $email;
$_SESSION['oldHome'] = $home;
$_SESSION['oldPhone'] = $phone;

if (empty($name)) {
    $_SESSION['nameError'] = "Full Name is empty!";
    $hasError = true;
}

if (empty($email)) {
    $_SESSION['emailError'] = "Email Address is empty!";
    $hasError = true;
}

if (empty($home)) {
    $_SESSION['homeError'] = "Home Address is empty!";
    $hasError = true;
}

if (empty($phone)) {
    $_SESSION['phoneError'] = "Phone # is empty!";
    $hasError = true;
}

if (empty($password)) {
    $_SESSION['passError'] = "Password is empty!";
    $hasError = true;
}

if (empty($confirm)) {
    $_SESSION['confirmError'] = "Confirm Password is empty!";
    $hasError = true;
}

if ($password !== $confirm) {
    $_SESSION['confirmError'] = "Password doesn't match!";
    $hasError = true;
}

if ($hasError) {
    header("Location: ../../pages/register.php");
    exit;
}


try {
    $check = $pdo->prepare("SELECT * FROM accounts WHERE email = :email");
    $check->execute([":email" => $email]);
    $result = $check->fetch();

    if ($result) {
        $_SESSION['emailError'] = "Email already exists!";
        header("Location: ../../pages/register.php");
        exit;
    }
    
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO accounts (fullname, email, phone, address, password) VALUES (:fullname, :email, :phone, :address, :password)");
    $stmt->execute([
        ':fullname' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':address' => $home,
        ':password' => $hash
    ]);

    $_SESSION['aid'] = $pdo->lastInsertId();
    $_SESSION['fullname'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $home;

    $stmt = $pdo->prepare("SELECT role FROM accounts WHERE aid = ?");
    $stmt->execute([$_SESSION['aid']]);
    $result = $stmt->fetch();
    
    $_SESSION['role'] = $result;

    header("Location: ../../pages/create-profile.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/register.php");
    exit;
}