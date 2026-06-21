<?php

require_once __DIR__ . '/../auth/auth.php';
require_once __DIR__ . '/../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid Request");
}

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    $_SESSION['error'] = "You do not have the request permission to access this processor.";
    header("Location: ../../pages/profile.php");
    exit;
}

$id = $_POST['id'] ?? null;

if (!$id) {
    die("Invalid student ID");
}

if (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] !== 0) {
    $_SESSION['error_photo'] = "Please select a valid image.";
    header("Loction: ../../students/edit.php?id=$id");
    exit;
}

$file = $_FILES['profile_photo'];

$allowed = ['jpg', 'jpeg', 'png', 'webp'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); 

if (!in_array($ext, $allowed)) {
    $_SESSION['error_photo'] = "Only JPG, JPEG, PNG, WEBP allowed.";
    header("Location: ../../students/edit.php?id=$id");
    exit;
}

$uploadDir = "../../assets/profile_photo/";

$newName = "student_" . $id . "_" . time() . "." . $ext;
$targetPath = $uploadDir . $newName;

try {
    $stmt = $pdo->prepare("SELECT profile_photo FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $old = $stmt->fetchColumn();

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $stmt = $pdo->prepare("UPDATE students SET profile_photo = ? WHERE id = ?");
        $stmt->execute([$newName, $id]);

        if ($old && file_exists($uploadDir . $old)) {
            unlink($uploadDir . $old);
        }

        $_SESSION['success'] = "Profile photo updated successfully!";
    }
    else {
        $_SESSION['error_photo'] = "Failed to upload image.";
    }

    header("Location: ../../students/edit.php?id=$id");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error_photo'] = "Database error: " . $e->getMessage();
    header("Location: ../../students/edit.php?id=$id");
    exit;
}