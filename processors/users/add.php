<?php
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/users.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "You do not have the permission to add a user.";
    header("Location: ../../pages/users.php");
    exit;
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$home = trim($_POST['home']);
$phone = trim($_POST['phone']);
$password = trim($_POST['password']);
$confirm = trim($_POST['confirm']);
$role = trim($_POST['role']);

$hasError = false;

$_SESSION['oldName'] = $name;
$_SESSION['oldEmail'] = $email;
$_SESSION['oldHome'] = $home;
$_SESSION['oldPhone'] = $phone;
$_SESSION['oldRole'] = $role;

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

if (empty($role)) {
    $_SESSION['roleError'] = "Role is empty!";
    $hasError = true;
}

if ($password !== $confirm) {
    $_SESSION['confirmError'] = "Password doesn't match!";
    $hasError = true;
}

if ($hasError) {
    $_SESSION['error'] = $password . " and " .  $confirm;
    header("Location: ../../pages/users/add.php");
    exit;
}


try {
    $check = $pdo->prepare("SELECT * FROM accounts WHERE email = :email");
    $check->execute([":email" => $email]);
    $result = $check->fetch();

    if ($result) {
        $_SESSINO['error'] = "Email already exists!";
        header("Location: ../../pages/register.php");
        exit;
    }
    
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO accounts (fullname, email, phone, address, password, role) VALUES (:fullname, :email, :phone, :address, :password, :role)");
    $stmt->execute([
        ':fullname' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':address' => $home,
        ':password' => $hash,
        ":role" => $role
    ]);

    $_SESSION['aid'] = $pdo->lastInsertId();
    $_SESSION['fullname'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;
    $_SESSION['address'] = $home;

    $stmt = $pdo->prepare("SELECT role FROM accounts WHERE aid = ?");
    $stmt->execute([$_SESSION['aid']]);
    $result = $stmt->fetch();
    
    $_SESSION['success'] = "User Added Successfully";

    unset($_SESSION['oldName']);
    unset($_SESSION['oldEmail']);
    unset($_SESSION['oldHome']);
    unset($_SESSION['oldPhone']);
    unset($_SESSION['oldRole']);

    header("Location: ../../pages/users/add.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/users/add.php");
    exit;
}