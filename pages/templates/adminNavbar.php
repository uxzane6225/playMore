<?php
    require_login();
?>
<div class="h-full flex fixed lg:static">
    <nav id="navbar" class="h-full w-full flex flex-col justify-between bg-white shadow-xl hidden lg:flex">
        <header class="p-3 text-center bg-red-600 rounded-b-3xl shadow-xl">
            <h1 class="m-3 p-3 text-xl font-bold text-red-600 bg-white rounded-3xl md:text-3xl">Control Panel</h1>
        </header>
        <ul class="p-3 h-full flex flex-col text-red-600">
            <a href="<?= BASE_URL ?>pages/dashboard.php" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Dashboard</a>
            <a href="<?= BASE_URL ?>pages/toys.php" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Toys</a>
            <a href="<?= BASE_URL ?>pages/users.php" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Users</a>
            <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Sales</a>
            <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Reports</a>
        </ul>
        <div class="p-3 flex flex-col gap-3 bg-red-600 rounded-t-xl shadow-xl">
            <div class="p-1 flex bg-white rounded-3xl gap-5">
                <img src="../../resources/images/blankPfp.jpg" alt="profile picture" class="w-20 h-20 bg-gray-300 rounded-full">
                <div class="w-full flex flex-col justify-center">
                    <a href="<?= BASE_URL ?>pages/profilePage.php" class="text-xl font-bold"><?= $_SESSION['username']; ?></a>
                    <p><?= $_SESSION['email'] ?></p>
                </div>
            </div>
            <div class="p-3 flex flex-col bg-white rounded-3xl">
                <a href="profile.php" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Main Site</a>
                <a href="" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Settings</a>
                <a href="<?= BASE_URL ?>processors/auth/logoutAuth.php" class="p-2 w-full text-lg transition duration-300 rounded-lg hover:bg-red-100">Logout</a>
            </div>
        </div>
    </nav>
    <div id="showBar" class="py-2 px-2 h-fit w-fit flex item-center justify-center text-xl bg-red-500 rounded-r-xl cursor-pointer lg:hidden">
        >
    </div>
</div>

<script src="../../scripts/adminNavbarScript.js"></script>