<?php
require('config/database.php');

if ($pdo) {
    header("Location: pages/welcome.php");
    exit;
}
?>