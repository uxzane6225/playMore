<?php
require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/profile.php?id=" . $_SESSION['aid']);
    exit;
}

$aid = $_SESSION['aid'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$confirm = trim($_POST['confirm']);

$hasError = false;

if (empty($name)) {
    $_SESSION['nameError'] = "Full Name is empty!";
    $hasError = true;
}

if (empty($email)) {
    $_SESSION['emailError'] = "Email Address is empty!";
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

if (!empty($password)) {
    if ($password !== $confirm) {
        $_SESSION['confirmError'] = "Password doesn't match!";
        $hasError = true;
    }
}

if ($hasError) {
    header("Location: ../../pages/profile.php?id={$aid}");
    exit;
}

try {
    $check = $pdo->prepare("SELECT * FROM accounts WHERE aid = :aid");
    $check->execute([":aid" => $aid]);
    $result = $check->fetch();

    if (!$result) {
        $_SESSION['updateError'] = "Account doesn't exist!";
        header("Location: ../../pages/profile.php?aid={$aid}");
        exit;
    }
    if (empty($password)) {
        $stmt = $pdo->prepare(" UPDATE accounts SET fullname = :fullname, email = :email WHERE aid = :aid");
        $stmt->execute([
            ':fullname' => $name,
            ':email' => $email,
            "aid" => $aid
        ]);
    }
    else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE accounts SET fullname = :fullname, email = :email, password = :password WHERE aid = :aid");
        $stmt->execute([
            ':fullname' => $name,
            ':email' => $email,
            ':password' => $hash,
            "aid" => $aid
        ]);
    }
    
    $_SESSION['updateSuccess'] = "User Updated Successfully";

    $_SESSION['fullname'] = $name;
    $_SESSION['email'] = $email;


    header("Location: ../../pages/profile.php?id={$aid}");
    exit;
}
catch (PDOException $e) {
    $_SESSION['updateError'] = $e->getMessage();
    header("Location: ../../pages/profile.php?id={$aid}");
    exit;
}