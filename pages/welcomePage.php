<?php 
session_start();
require('../config/database.php');

$_SESSION['title'] = "Welcome Page";

include('templates/header.php');
?>
<header class="h-full flex flex-col items-center justify-center gap-5 text-center bg-red-500 text-white shadow-xl lg:h-3/4 lg:flex-row lg:justify-evenly">
    <div class="flex flex-col items-center justify-cente gap-5">
        <div>
            <h1 class="font-bold text-3xl">playMore.com!</h1>
            <p>Play more than you could imagine!</p>
        </div>
        <div class="flex items-center gap-5 text-2xl">
            <a href="loginPage.php" class="py-1 px-3 text-black bg-white rounded-lg transition duration-300 hover:bg-gray-100">Login</a>
            <a href="registerPage.php" class="transition duration-300 font-medium hover:text-gray-100">Register</a>
        </div>
    </div>
    <img src="../resources/images/header.jpg" alt="Header Toy" class="w-96 h-96 hidden rounded-lg transition duration-300 shadow-xl hover:scale-110 lg:block">
</header>
<main class="px-5 py-10 w-full">
    <header class="flex flex-col gap-5">
        <h2 class="text-center text-3xl font-medium">About</h2>
        <p class="text-justify">playMore is a toy store for everyone! We sell brand new toys for children and vintage toys for collectors, because we believe that everyone should enjoy owning and playing a toy.</p>
    </header>
</main>
<?php include('templates/footer.php'); ?>