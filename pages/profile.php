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
        <p><?= isset($_SESSION['pfp']) ? $_SESSION['pfp'] : "blankPfp.jpg" ?></p>
    </div>
</header>
<main class="m-5 p-5 flex flex-col gap-5">
    <h2 class="text-2xl font-bold">Profile Settings <?= isset($_SESSION['error']) ? $_SESSION['error'] : ''; unset($_SESSION['error']) ?></h2>
    <form action="../processors/profile/edit.php" method="POST" class="flex flex-col gap-2 text-lg" enctype="multipart/form-data">
        <div class="flex flex-col gap-1">
            <input type="file" id="pfp" name="pfp" class="p-2.5 text-white bg-red-600 rounded-xl cursor-pointer" aria-label="profile picture">
            <?php if(isset($_SESSION['pfpError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['pfpError']; ?></p>
                <?php unset($_SESSION['pfpError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-1">
            <label for="username">Username</label>
            <input type="text" id="user" name="user" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400"  value="<?= isset($_SESSION['oldUser']) ? $_SESSION['oldUser'] : $_SESSION['username'] ?>">
            <?php if(isset($_SESSION['userError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['userError']; ?></p>
                <?php unset($_SESSION['userError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-1">
            <label for="bio">Bio</label>
            <input type="text" id="bio" name="bio" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400"  value="<?= isset($_SESSION['oldBio']) ? $_SESSION['oldBio'] : $_SESSION['bio'] ?>">
            <?php if(isset($_SESSION['bioError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['bioError']; ?></p>
                <?php unset($_SESSION['bioError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-1">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <option value="male" class="w-fit">Male</option>
                <option value="female" class="w-fit">Female</option>
            </select>
            <?php if(isset($_SESSION['genderError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['genderError']; ?></p>
                <?php unset($_SESSION['genderError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col">
            <label for="birth" class="pl-2">Birthday</label>
            <input type="date" id="birth" name="birth" value="<?= isset($_SESSION['oldBirthdate']) ? $_SESSION['oldBirthdate'] : $_SESSION['birthdate'] ?>" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['birthError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['birthError']; ?></p>
                <?php unset($_SESSION['birthError']); ?>
            <?php endif; ?>
        </div>

        <button type="submit" name="edit" class="py-2 px-5 w-fit bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-700">Edit</button>
    </form>
</main>
<footer class="p-10 text-white text-center bg-red-600">
    <p>&copy; playMore.test. Rights Reserved <?= date('Y') ?></p>
</footer>
<?php include('templates/foot.php'); ?>