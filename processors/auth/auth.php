<?php
session_start();

require __DIR__ . '/../../config/database.php';

define('BASE_URL', '/');

$timeout = 1800;

if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $timeout) {
        session_unset();
        session_destroy();
        session_start();
    }
}

$_SESSION['last_activity'] = time();

if (!isset($_SESSION['aid']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];

    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE remember_token = ?');
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['aid'] = $user['aid'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['last_activity'] = time();
    }
    else {
        setcookie("remember_token", "", time() - 3600, "/");
    }
}

function require_login() {
    if (!isset($_SESSION['aid'])) {
        header("Location: " . BASE_URL . "login.php");
        exit;
    }
}

function require_guest() {
    if (isset($_SESSION['aid'])) {
        header("Location: " . BASE_URL . "pages/dashboard.php");
        exit;
    }
}