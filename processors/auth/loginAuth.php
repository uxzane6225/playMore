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
$remember = $_POST['remember'];

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
    $check = $pdo->prepare("SELECT * FROM accounts WHERE email = :email");
    $check->execute([":email" => $email]);
    $account = $check->fetch(PDO::FETCH_ASSOC);

    if (!$account) {
        $_SESSION['emailError'] = "Email doesn't exists!";
        header("Location: ../../pages/login.php");
        exit;
    }

    if (!password_verify($password, $account['password'])) {
        $_SESSION['passError'] = "Invalid password!";
        header("Location: ../../pages/login.php");
        exit;
    }

    $_SESSION['aid'] = $account['aid'];
    $_SESSION['fullname'] = $account['fullname'];
    $_SESSION['email'] = $account['email'];
    //$_SESSION['phone'] = $result['phone'];
    //$_SESSION['address'] = $result['address'];
    $_SESSION['role'] = $account['role'];

    if ($remember) {
        $token = bin2hex(random_bytes(32));

        $update = $pdo->prepare('UPDATE accounts SET remember_token = ? WHERE aid = ?');
        $update->execute([$token, $account['aid']]);

        setcookie('remember_token', $token, time() + (84600 * 30), "/", "", false, true);
        setcookie('remember_email', $email, time() + (84600 * 30), '/');
    }

    $check = $pdo->prepare("SELECT * FROM profiles WHERE aid = :aid");
    $check->execute([":aid" => $account['aid']]);
    $profile = $check->fetch(PDO::FETCH_ASSOC);
    
    if (empty($profile['username'])) {
        header("Location: ../../pages/create-profile.php");
        exit;
    }

    $_SESSION['pfp'] = $profile['pfp'];
    $_SESSION['username'] = $profile['username'];
    $_SESSION['bio'] = $profile['bio'];
    $_SESSION['gender'] = $profile['gender'];
    $_SESSION['birthdate'] = $profile['birthdate'];

    switch ($account['role']) {
        case "admin":
            header("Location: ../../pages/dashboard.php");    
            break;
        case "staff":
            header("Location: ../../pages/dashboard.php");    
            break;
        default:
            header("Location: ../../pages/profile.php");    
    }
   
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/login.php");
    exit;
}