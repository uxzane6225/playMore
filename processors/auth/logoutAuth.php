<?php
session_start();

// session_unset();
// session_destroy();

require __DIR__ . '/../../config/database.php';

if (isset($_SESSION['aid'])) {
    $aid = $_SESSION['aid'];
    $stmt = $pdo->prepare("UPDATE accounts SET remember_token = null WHERE aid = ?");
    $stmt->execute([$aid]);
}

$_SESSION = [];
session_unset();
session_destroy();

setcookie('remember_token', "", time() - 3600, "/");
setcookie('remember_email', "", time() -3600, "/");

header("Location: login.php");

header("Location: ../../pages/welcome.php");
exit;