<nav class="p-5 w-full text-white bg-red-600 rounded-b-3xl lg:flex">
    <button id="expand" class="w-full font-bold lg:hidden">Expand</button>
    <div id="navbar" class="mt-1 w-full flex flex-col justify-between gap-2 text-xl lg:flex-row lg:gap-0 hidden lg:flex lg:text-lg">
        <a href="" class="font-bold">playMore</a>
        <ul class="flex flex-col gap-2 lg:flex-row lg:gap-10">
            <li><a href="home.php" class=" transition duration-300 hover:text-yellow-200">Home</a></li>
            <li><a href="shop.php" class=" transition duration-300 hover:text-yellow-200">Shop</a></li>
            <li><a href="contact.php" class="transition duration-300 hover:text-yellow-200">Contact</a></li>
            <li><a href="about.php" class="transition duration-300 hover:text-yellow-200">About</a></li>
            <a href="profile.php?id=<?= $_SESSION['aid'] ?>">Profile</a>
            <?php if($_SESSION['role'] === "admin"): ?>
                <li><a href="dashboard.php" class="transition duration-300 hover:text-yellow-200">Control Panel</a></li>
            <?php endif; ?>
        </ul>
        <a href="../../processors/auth/logoutAuth.php">Logout</a>
    </div>
</nav>
<script src="../../scripts/navbarScript.js"></script>