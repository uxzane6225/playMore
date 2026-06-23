<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Welcome";

include('templates/head.php');
include('templates/navbar.php');
?>
<header class="m-5 p-5 flex flex-col items-center gap-5 text-white bg-red-600 rounded-xl lg:flex-row lg:items-start">
    <img src="../storage/images/<?= isset($_SESSION['pfp']) ? $_SESSION['pfp'] : "blankPfp.jpg" ?>" alt="Profile Picture" class="w-60 h-60 border border-4 border-white rounded-full">
    <div class="text-center lg:py-5 lg:text-left">
        <h1 class="text-xl font-bold lg:text-3xl"><?= $_SESSION['username']; ?>'s Profile</h1>
        <p><?= isset($_SESSION['bio']) ? $_SESSION['bio'] : "No description"; ?></p>
    </div>
</header>
<main class="m-5 p-5">
    
</main>
<footer class="p-10 text-white text-center bg-red-700">
    <p>&copy; playMore.test. Rights Reserved <?= date('Y') ?></p>
</footer>
<?php include('templates/foot.php'); ?>