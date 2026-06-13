<?php
require('config/database.php');

if ($pdo) {
    header("Location: pages/welcomePage.php");
    exit;
}
?>