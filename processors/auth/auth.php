<?php
require('../../config/database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "You do not have the permission to execute this process.";
    header("Location: ../../pages/loginPage.php");
    exit;
}

if (isset($_POST['login'])) {
    
}