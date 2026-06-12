<?php
    require('config/database.php');

    if ($pdo) {
        header("Location: welcomePage.php");
        exit;
    }
?>