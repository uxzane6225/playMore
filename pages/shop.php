<?php
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Shop";

include 'templates/head.php';
include 'templates/navbar.php';
?>
<main class="h-full w-full flex flex-col items-center justify-center">
    <h1 class="text-2xl font-bold">Under Construction!</h1>
    <p>This part of the website is still unfinished.</p>
</main>
<footer class="p-5 w-full bg-red-600 text-white">
    <p><span class="font-bold">&copy;</span> Uriel Laurence M. Mendoza | 2nd Year - 3rd Trimester | ITWS Finals Project</p>
</footer>
<?php include('templates/foot.php'); ?>