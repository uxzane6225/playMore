<?php
require('../../config/database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "You do not have the permission to execute this process.";
    header("Location: ../../pages/createProfilePage.php");
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
$_SESSION['error'] = "Before going through error!";

if ($hasError) {
    header("Location: ../../pages/createProfilePage.php");
    exit;
}

$_SESSION['error'] = "I went through hasError seems to be no error!";

try {
    $stmt = $pdo->prepare("INSERT INTO profiles (aid, username, bio, gender, birthdate) VALUES (:aid, :username, :bio, :gender, :birthdate)");
    $stmt->execute([
        ":aid" => $_SESSION['aid'],
        ":username" => $user,
        ":bio" => $bio,
        ":gender" => $gender,
        ":birthdate" => $birthdate,
    ]);

    $_SESSION['user'] = $user;
    $_SESSION['bio'] = $bio;
    $_SESSION['gender'] = $gender;
    $_SESSION['birthdate'] = $birthdate;
    
    header("Location: ../../pages/dashboardPage.php");
    exit;
}
catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: ../../pages/createProfilePage.php");
    exit;
}