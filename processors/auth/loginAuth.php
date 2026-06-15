<?php
require('../../config/database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "You do not have the permission to execute this process.";
    header("Location: ../../pages/login.php");
    exit;
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$hasError = false;

$_SESSION['oldEmail'] = $email;

if (empty($email)) {
    $_SESSION['emailError'] = "Email Address is empty!";
    $hasError = true;
}

if (empty($password)) {
    $_SESSION['passError'] = "Password is empty!";
    $hasError = true;
}

if ($hasError) {
    header("Location: ../../pages/login.php");
    exit;
}

try {
    $check = $pdo->prepare("SELECT * FROM accounts a INNER JOIN profiles p ON a.aid = p.aid WHERE email = :email");
    $check->execute([":email" => $email]);
    $result = $check->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        $_SESSION['emailError'] = "Email doesn't exists!";
        header("Location: ../../pages/login.php");
        exit;
    }

    if (!password_verify($password, $result['password'])) {
        $_SESSION['passError'] = "Invalid password!";
        header("Location: ../../pages/login.php");
        exit;
    }

    $_SESSION['aid'] = $result['aid'];
    $_SESSION['fullname'] = $result['fullname'];
    $_SESSION['email'] = $result['email'];
    $_SESSION['phone'] = $result['phone'];
    $_SESSION['address'] = $result['address'];
    $_SESSION['role'] = $result['role'];
    
    $_SESSION['pfp'] = $result['pfp'];
    $_SESSION['username'] = $result['username'];
    $_SESSION['bio'] = $result['bio'];
    $_SESSION['gender'] = $result['gender'];
    $_SESSION['birthdate'] = $result['birthdate'];

    header("Location: ../../pages/profile.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/login.php");
    exit;
}