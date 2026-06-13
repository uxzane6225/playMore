<?php 
session_start();
require('../config/database.php');

$_SESSION['title'] = "Welcome Page";

include('templates/header.php');
?>
<main class="h-screen flex">
    <form action="../processors/auth/auth.php" method="POST" class="w-full flex flex-col items-center justify-evenly text-white bg-red-500 lg:w-3/6">
        <h2 class="text-3xl font-bold lg:text-4xl md:hidden">playMore</h2>
        <h2 class="hidden text-3xl font-bold lg:text-4xl md:block">Login</h2>
        <div class="px-10 w-full flex flex-col gap-3 text-xl">
            <div class="flex flex-col gap-1">
                <label for="email" class="pl-2">Email</label>
                <input type="email" id="email" name="email" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" autocomplete="email"" required>
            </div>
            <div class="flex flex-col gap-1">
                <label for="password" class="pl-2">Password</label>
                <input type="password" id="password" name="password" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" autocomplete="current-password" required>
            </div>
        </div>
        
        <div class="flex flex-col items-center gap-1">
            <button type="submit" name="login" class="py-2 px-5 w-fit bg-white text-black rounded-lg transition duration-300 hover:bg-gray-100">Sign In</button>
            <a href="registerPage.php" class="text-md underline lg:text-sm">Dont have an account? Register!</a>
        </div>
    </form>
    <div class="hidden w-full bg-red-500 md:block md:bg-[url(/../resources/images/authBG.jpg)] bg-center bg-cover">
        <div class="w-full h-full flex flex-col items-center justify-center text-white backdrop-brightness-50">
            <h1 class="font-bold text-5xl">playMore.com</h1>
            <p class="text-lg">Play more than you could imagine!</p>
        </div>
    </div>
</main>
<?php include('templates/footer.php'); ?>