<?php
require('../../config/database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "You do not have the permission to execute this process.";
    header("Location: ../../pages/create-profile.php");
    exit;
}

$user = trim($_POST['user']);
$bio = trim($_POST['bio']);
$gender = trim($_POST['gender']);
$birthdate = trim($_POST['birth']);

$hasError = false;

$_SESSION['oldUser'] = $user;
$_SESSION['oldBio'] = $bio;
$_SESSION['oldGender'] = $gender;
$_SESSION['oldBirthdate'] = $birthdate;

if (empty($user)) {
    $_SESSION['userError'] = "Full user is empty!";
    $hasError = true;
}

if (empty($bio)) {
    $_SESSION['bioError'] = "Bio is empty!";
    $hasError = true;
}

if (empty($gender)) {
    $_SESSION['genderError'] = "You did not pick a gender!";
    $hasError = true;
}

if (empty($birthdate)) {
    $_SESSION['birthError'] = "Birthdate is empty!";
    $hasError = true;
}

if ($hasError) {
    header("Location: ../../pages/create-profile.php");
    exit;
}

try {
    $file = $_FILES['pfp'];

    if (!empty($file['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $_SESSION['pfpError'] = "Only JPG, JPEG, PNG, WEBP allowed.";
            header("Location: ../../pages/create-profile.php");
            exit;
        }

        $uploadDir = "../../storage/images/";

        $newName = "user_" . $_SESSION['aid'] . "_" . time() . "." . $ext;
        $targetPath = $uploadDir . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $stmt = $pdo->prepare("INSERT INTO profiles (aid, pfp, username, bio, gender, birthdate) VALUES (:aid, :pfp, :username, :bio, :gender, :birthdate)");
            $stmt->execute([
                ":aid" => $_SESSION['aid'],
                ":pfp" => $newName,
                ":username" => $user,
                ":bio" => $bio,
                ":gender" => $gender,
                ":birthdate" => $birthdate,
            ]);
        }
    }
    else {
        $stmt = $pdo->prepare("INSERT INTO profiles (aid, username, bio, gender, birthdate) VALUES (:aid, :username, :bio, :gender, :birthdate)");
        $stmt->execute([
            ":aid" => $_SESSION['aid'],
            ":username" => $user,
            ":bio" => $bio,
            ":gender" => $gender,
            ":birthdate" => $birthdate,
        ]);
    }

    $_SESSION['username'] = $user;
    $_SESSION['bio'] = $bio;
    $_SESSION['gender'] = $gender;
    $_SESSION['birthdate'] = $birthdate;
    
    header("Location: ../../pages/profile.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/create-profile.php");
    exit;
}