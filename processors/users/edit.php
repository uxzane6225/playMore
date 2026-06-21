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

$aid = $_SESSION['targetAid'] ?? 0;
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$home = trim($_POST['home']);
$phone = trim($_POST['phone']);
$password = trim($_POST['password']);
$confirm = trim($_POST['confirm']);
$role = trim($_POST['role']);

$hasError = false;

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

if (!empty($password)) {
    if (empty($confirm)) {
        $_SESSION['confirmError'] = "Confirm Password is empty!";
        $hasError = true;
    }

    if ($password !== $confirm) {
        $_SESSION['confirmError'] = "Password doesn't match!";
        $hasError = true;
    }
}

if (empty($role)) {
    $_SESSION['roleError'] = "Role is empty!";
    $hasError = true;
}

if (!empty($password)) {
    if ($password !== $confirm) {
        $_SESSION['confirmError'] = "Password doesn't match!";
        $hasError = true;
    }
}

if ($hasError) {
    header("Location: ../../pages/users/edit.php?aid={$aid}");
    exit;
}


try {
    $check = $pdo->prepare("SELECT * FROM accounts WHERE aid = :aid");
    $check->execute([":aid" => $aid]);
    $result = $check->fetch();

    if (!$result) {
        $_SESSION['error'] = "Account doesn't exist!";
        header("Location: ../../pages/users/edit.php?aid={$aid}");
        exit;
    }

    if (empty($password)) {
        $stmt = $pdo->prepare(" UPDATE accounts SET fullname = :fullname, email = :email, phone = :phone, address = :address, role = :role WHERE aid = :aid");
        $stmt->execute([
            ':fullname' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $home,
            ":role" => $role,
            "aid" => $aid
        ]);
    }
    else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE accounts SET fullname = :fullname, email = :email, phone = :phone, address = :address, password = :password, role = :role WHERE aid = :aid");
        $stmt->execute([
            ':fullname' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $home,
            ':password' => $hash,
            ":role" => $role,
            "aid" => $aid
        ]);
    }
    
    
    $_SESSION['success'] = "User Updated Successfully";

    header("Location: ../../pages/users/edit.php?aid={$aid}");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/users/edit.php?aid={$aid}");
    exit;
}