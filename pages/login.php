<?php 
require_once __DIR__ . '/../processors/auth/auth.php';
require_guest();

require_once __DIR__ . '/../config/database.php';

$_SESSION['title'] = "Login";

include 'templates/head.php';
?>
<main class="h-screen flex">
    <form action="../processors/auth/loginAuth.php" method="POST" class="w-full flex flex-col items-center justify-evenly text-white bg-red-600 lg:w-3/6">
        
        <h2 class="hidden text-3xl font-bold lg:text-4xl md:block">Login</h2>    
        <header class="text-center md:hidden">
            <h2 class="text-3xl font-bold lg:text-4xl">playMore</h2>
            <p>Play more than you could imagine!</p>
        </header>

        <div class="px-10 w-full flex flex-col gap-3 text-xl">
            <div class="flex flex-col gap-1">
                <label for="email" class="pl-2">Email Address</label>
                <input type="email" id="email" name="email" value="<?= isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : ''; unset($_SESSION['oldEmail']);?>" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" autocomplete="email" >
                <?php if(isset($_SESSION['emailError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['emailError']; ?></p>
                    <?php unset($_SESSION['emailError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="password" class="pl-2">Password</label>
                <div class="p-1.5 flex gap-2 bg-white rounded-lg border lg:border-gray-400">
                    <input type="password" id="password" name="password" class="w-full text-black lg:focus:outline-red-400" autocomplete="current-password">
                    <button type="button" id="show" name="show" class="p-1 bg-red-600 rounded-lg">Show</button>
                </div>
                <div class="flex items-center justify-between">
                    <label for="show" class="pl-2 text-lg flex items-center gap-2"><input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded-lg cursor-pointer"> Remember Me</label>
                    <?php if(isset($_SESSION['passError'])): ?>
                        <p class="text-end text-xs"><?= $_SESSION['passError']; ?></p>
                        <?php unset($_SESSION['passError']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="text-center"><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <div class="flex flex-col items-center gap-1">
            <button type="submit" name="login" class="py-2 px-5 w-fit bg-white text-black text-xl rounded-lg transition duration-300 hover:bg-gray-100">Sign In</button>
            <a href="register.php" class="text-md underline lg:text-sm">Dont have an account? Register!</a>
        </div>
    </form>
    <div class="hidden w-full bg-black md:block md:bg-[url(/../resources/images/authBG.jpg)] bg-center bg-cover">
        <div class="w-full h-full flex flex-col items-center justify-center text-white backdrop-brightness-50">
            <h1 class="font-bold text-5xl">playMore.com</h1>
            <p class="text-lg">Play more than you could imagine!</p>
        </div>
    </div>
</main>
<script src="../scripts/loginScript.js"></script>                     
<?php include('templates/foot.php'); ?>