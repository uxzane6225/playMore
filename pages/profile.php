<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Welcome";

include('templates/head.php');
include('templates/navbar.php');

$_SESSION['targetedAid'] = $_SESSION['aid'];
?>
<header class="m-5 p-5 flex flex-col items-center gap-5 text-white bg-red-600 rounded-xl lg:flex-row lg:items-start">
    <img src="../storage/images/pfp/<?= isset($_SESSION['pfp']) ? $_SESSION['pfp'] : "blankPfp.jpg" ?>" alt="Profile Picture" class="w-60 h-60 border border-4 border-white rounded-full">
    <div class="text-center lg:py-5 lg:text-left">
        <h1 class="text-xl font-bold lg:text-3xl"><?= $_SESSION['username']; ?>'s Profile</h1>
        <p><?= isset($_SESSION['bio']) ? $_SESSION['bio'] : "No description"; ?></p>
        <!-- <p><?= isset($_SESSION['pfp']) ? $_SESSION['pfp'] : "blankPfp.jpg" ?></p> -->
    </div>
</header>
<main class="m-5 p-5 flex flex-col gap-10">
    <section class="flex flex-col gap-5">
        <header class="flex flex-col lg:flex-row gap-1 lg:gap-3">
            <h2 class="text-2xl font-bold">Profile Settings</h2>
            <?php if(isset($_SESSION['success'])): ?>
                <p class="py-1 px-5 self-center text-center text-green-300 bg-green-700 rounded-lg"><?= $_SESSION['success'] ?></p>
                <?php unset($_SESSION['success']) ?>
            <?php elseif(isset($_SESSION['error'])): ?>
                <p class="py-1 px-5 self-center text-red-200 text-center bg-red-500 rounded-lg"><?= $_SESSION['error'] ?></p>
                <?php unset($_SESSION['error']) ?>
            <?php endif; ?>
        </header>
        <form action="../processors/profile/edit.php" method="POST" class="flex flex-col gap-2 text-lg" enctype="multipart/form-data">
            <div class="flex flex-col gap-1">
                <input type="file" id="pfp" name="pfp" class="p-2.5 text-white bg-red-600 rounded-xl cursor-pointer" aria-label="profile picture">
                <?php if(isset($_SESSION['pfpError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['pfpError']; ?></p>
                    <?php unset($_SESSION['pfpError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="user">Username</label>
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
    </section>
    <section class="flex flex-col gap-5">
        <header class="flex flex-col lg:flex-row gap-1 lg:gap-3">
            <h2 class="text-2xl font-bold">Account Settings</h2>
            <?php if(isset($_SESSION['updateSuccess'])): ?>
                <p class="py-1 px-5 self-center text-green-300 bg-green-700 rounded-lg"><?= $_SESSION['updateSuccess'] ?></p>
                <?php unset($_SESSION['updateSuccess']) ?>
            <?php elseif(isset($_SESSION['updateError'])): ?>
                <p class="py-1 px-5 self-center text-red-200 bg-red-500 rounded-lg"><?= $_SESSION['updateError'] ?></p>
                <?php unset($_SESSION['updateError']) ?>
            <?php endif; ?>
        </header>
        
        <form action="../processors/users/update.php" method="POST" class="flex flex-col gap-2 text-lg" enctype="multipart/form-data">
            <div class="flex flex-col gap-1">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400"  value="<?= isset($_SESSION['oldName']) ? $_SESSION['oldName'] : $_SESSION['fullname'] ?>">
                <?php if(isset($_SESSION['nameError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['nameError']; ?></p>
                    <?php unset($_SESSION['nameError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400"  value="<?= isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : $_SESSION['email'] ?>">
                <?php if(isset($_SESSION['emailError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['emailError']; ?></p>
                    <?php unset($_SESSION['emailError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['passError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['passError']; ?></p>
                    <?php unset($_SESSION['passError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="confirm">Confirm Password</label>
                <input type="password" id="confirm" name="confirm" class="p-2.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['confirmError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['confirmError']; ?></p>
                    <?php unset($_SESSION['confirmError']); ?>
                <?php endif; ?>
            </div>

            <button type="submit" name="edit" class="py-2 px-5 w-fit bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-700">Update</button>
        </form>
    </section>
</main>
<footer class="p-10 text-white text-center bg-red-600">
    <p>&copy; playMore.test. Rights Reserved <?= date('Y') ?></p>
</footer>
<?php include('templates/foot.php'); ?>