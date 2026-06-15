<?php 
session_start();
require('../config/database.php');

$_SESSION['title'] = "Registration";

include('templates/head.php');
?>
<main class="h-full flex">
    <form action="../processors/auth/registerAuth.php" method="POST" class="h-full w-full flex flex-col items-center justify-evenly text-white bg-red-600 lg:w-3/6">
        <h2 class="hidden text-3xl font-bold lg:text-4xl md:block">Registration</h2>
        <header class="text-center md:hidden">
            <h2 class="text-3xl font-bold lg:text-xl">playMore</h2>
            <p>Play more than you could imagine!</p>
        </header>

        <div class="px-10 w-full flex flex-col gap-2 text-sm md:text-md">
            <div class="flex flex-col ">
                <label for="name" class="pl-2">Full Name</label>
                <input type="text" id="name" name="name" value="<?= isset($_SESSION['oldName']) ? $_SESSION['oldName'] : ''; unset($_SESSION['oldName']);?>" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" >
                <?php if(isset($_SESSION['nameError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['nameError']; ?></p>
                    <?php unset($_SESSION['nameError']); ?>
                <?php endif; ?>
            </div>
            <div class="flex flex-col ">
                <label for="email" class="pl-2">Email Address</label>
                <input type="email" id="email" name="email" value="<?= isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : ''; unset($_SESSION['oldEmail']);?>" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" autocomplete="email" >
                <?php if(isset($_SESSION['emailError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['emailError']; ?></p>
                    <?php unset($_SESSION['emailError']); ?>
                <?php endif; ?>
            </div>
            <div class="flex flex-col ">
                <label for="home" class="pl-2">Home Address</label>
                <input type="text" id="home" name="home" value="<?= isset($_SESSION['oldHome']) ? $_SESSION['oldHome'] : ''; unset($_SESSION['oldHome']);?>" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" >
                <?php if(isset($_SESSION['homeError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['homeError']; ?></p>
                    <?php unset($_SESSION['homeError']); ?>
                <?php endif; ?>
            </div>
            <div class="flex flex-col ">
                <label for="phone" class="pl-2">Phone #</label>
                <input type="text" id="phone" name="phone" value="<?= isset($_SESSION['oldPhone']) ? $_SESSION['oldPhone'] : ''; unset($_SESSION['oldPhone']);?>" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" >
                <?php if(isset($_SESSION['phoneError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['phoneError']; ?></p>
                    <?php unset($_SESSION['phoneError']); ?>
                <?php endif; ?>
            </div>
            <div class="flex flex-col ">
                <label for="password" class="pl-2">Password</label>
                <input type="password" id="password" name="password" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" autocomplete="current-password" >
                <?php if(isset($_SESSION['passError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['passError']; ?></p>
                    <?php unset($_SESSION['passError']); ?>
                <?php endif; ?>
            </div>
            <div class="flex flex-col ">
                <label for="confirm" class="pl-2">Confirm Password</label>
                <input type="password" id="confirm" name="confirm" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" autocomplete="current-password" >
                <?php if(isset($_SESSION['confirmError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['confirmError']; ?></p>
                    <?php unset($_SESSION['confirmError']); ?>
                <?php endif; ?>
            </div>
        </div>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="text-center"><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <div class="flex flex-col items-center gap-1">
            <button type="submit" name="register" class="py-2 px-5 w-fit bg-white text-black text-xl rounded-lg transition duration-300 hover:bg-gray-200">Sign Up</button>
            <a href="login.php" class="text-md underline lg:text-sm">Already have an account? Login!</a>
        </div>
    </form>
    <div class="hidden w-full bg-black md:block md:bg-[url(/../resources/images/authBG.jpg)] bg-center bg-cover">
        <div class="w-full h-full flex flex-col items-center justify-center text-white backdrop-brightness-50">
            <h1 class="font-bold text-5xl">playMore.com</h1>
            <p class="text-lg">Play more than you could imagine!</p>
        </div>
    </div>
</main>
<?php include('templates/foot.php'); ?>