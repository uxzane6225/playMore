<?php
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Home";

include 'templates/head.php';
?>
<header class="h-full flex flex-col items-center justify-center gap-5 text-center bg-red-600 text-white shadow-xl lg:h-3/4 lg:justify-evenly">
    <?php include 'templates/navbar.php'; ?>
    <div class="w-full h-full flex flex-col items-center justify-evenly gap-5 lg:flex-row">
        <div class="flex flex-col items-center justify-cente gap-5">
            <div>
                <h1 class="font-bold text-3xl">playMore.com!</h1>
                <p>Play more than you could imagine!</p>
            </div>
        </div>
        <img src="../resources/images/header.jpg" alt="Header Toy" class="w-96 h-96 hidden rounded-lg transition duration-300 shadow-xl hover:scale-110 lg:block">
    </div>
</header>
<main class="p-10 lg:px-0 w-full flex flex-col items-center gap-10">
    <section class="w-full flex flex-col justify-center items-center gap-10 lg:w-4/6 lg:flex-row">
        <img src="../resources/images/stock1.jpg" alt="Stock 1" class="object-contain w-96 h-96 hidden rounded-lg transition duration-300 shadow-xl hover:scale-110 lg:block">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-medium">About</h2>
            <p>playMore is a toy store for everyone! We sell brand new and vintage toys for both children and adults, it doesn't matter if you're going to be playing with it or collecting toys, because We believe that everyone should enjoy owning and playing toys regardless of everything!</p>
        </div>
    </section>
    <section class="w-full flex flex-col justify-center items-center gap-10 lg:w-4/6 lg:flex-row">
        <div class="flex flex-col gap-2">
            <h2 class="text-right text-3xl font-medium">Why us?</h2>
            <p class="text-right">We offer unique, and high quality services! Down from site user-experiences to effective technical support! We care about how our customers' deeply feel about the service we provide.</p>
        </div>
        <img src="../resources/images/stock2.jpg" alt="Stock 2" class="w-96 h-96 hidden rounded-lg transition duration-300 shadow-xl hover:scale-110 lg:block">
    </section>
</main>
<footer class="p-5 bg-red-600 text-white">
    <p><span class="font-bold">&copy;</span> Uriel Laurence M. Mendoza | 2nd Year - 3rd Trimester | ITWS Finals Project</p>
</footer>
<?php include('templates/foot.php'); ?>