<?php
require '../../config/database.php';
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
    // $stmt = $pdo->prepare("SELECT pid WHERE aid = ?");
    // $stmt->execute([$_SESSION['aid']]);
    // $pid = $stmt->fetchColumn();

    $file = $_FILES['pfp'];

    if (!empty($file['name'])) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $_SESSION['pfpError'] = "Only JPG, JPEG, PNG, WEBP allowed.";
            header("Location: ../../pages/create-profile.php");
            exit;
        }

        $uploadDir = "../../storage/images/pfp/";

        $newName = "user_" . $_SESSION['aid'] . "_" . time() . "." . $ext;
        $targetPath = $uploadDir . $newName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $stmt = $pdo->prepare("UPDATE profiles SET pfp = :pfp, username = :username, bio = :bio, gender = :gender, birthdate = :birthdate WHERE pid = :pid");
            $stmt->execute([
                ":pid" => $_SESSION['pid'],
                ":pfp" => $newName,
                ":username" => $user,
                ":bio" => $bio,
                ":gender" => $gender,
                ":birthdate" => $birthdate,
            ]);
        }
    }
    else {
        $stmt = $pdo->prepare("UPDATE profiles SET username = :username, bio = :bio, gender = :gender, birthdate = :birthdate WHERE pid = :pid");
        $stmt->execute([
            ":pid" => $_SESSION['pid'],
            ":username" => $user,
            ":bio" => $bio,
            ":gender" => $gender,
            ":birthdate" => $birthdate,
        ]);
    }

    $_SESSION['pfp'] = $newName ?? $_SESSION['pfp'];
    //$_SESSION['pfp'] = $newName ?? isset($_SESSION['pfp']) ? $_SESSION['pfp'] : 'blankPfp.jpg';
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