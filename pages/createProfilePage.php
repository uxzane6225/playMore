<?php 
session_start();
require('../config/database.php');

$_SESSION['title'] = "Create Profile";

if (empty($_SESSION['aid'])) {
    $_SESSION['error'] = "You're not allowed to access the Create Profile Page, due to the lack of ID present";
    header("Location: registerPage.php");
    exit;
}

echo $_SESSION['aid'];

include('templates/head.php');
?>
<main class="h-full flex flex-col md:justify-center md:items-center md:bg-red-600">
    <form action="../processors/auth/createProfileProcessor.php" method="POST" class="h-full w-full flex flex-col justify-between md:h-fit md:w-fit md:bg-white md:rounded-xl md:shadow-2xl">
        <div class="h-1/3 flex flex-col items-center justify-center gap-3 md:p-5">
            <img src="../resources/images/blankPfp.jpg" alt="Profile Picture" class="w-40 h-40 bg-gray-200 border border-red-600 rounded-full">
            <input type="file" id="pfp" name="pfp" class="w-fit text-white bg-red-600 rounded-xl" aria-label="profile picture">
        </div>
        <div class="p-5 h-2/3 w-full flex flex-col items-center justify-around gap-3 text-white bg-red-600 rounded-t-xl md:rounded-xl">
            <h1 class="text-2xl font-bold">Create Profile</h1>
            <div class="w-full flex flex-col gap-2">
                <div class="flex flex-col">
                    <label for="user" class="pl-2">Username</label>
                    <input type="text" id="user" name="user" value="<?= isset($_SESSION['oldUser']) ? $_SESSION['oldUser'] : ''; unset($_SESSION['oldUser']);?>" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" >
                    <?php if(isset($_SESSION['userError'])): ?>
                        <p class="text-end text-xs"><?= $_SESSION['userError']; ?></p>
                        <?php unset($_SESSION['userError']); ?>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col">
                    <label for="bio" class="pl-2">Bio</label>
                    <input type="text" id="bio" name="bio" value="<?= isset($_SESSION['oldBio']) ? $_SESSION['oldBio'] : ''; unset($_SESSION['oldBio']);?>" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" >
                    <?php if(isset($_SESSION['bioError'])): ?>
                        <p class="text-end text-xs"><?= $_SESSION['bioError']; ?></p>
                        <?php unset($_SESSION['bioError']); ?>
                    <?php endif; ?>
                </div>

                <div class="flex flex-col">
                    <label for="gender" class="pl-2">Gender</label>
                    <select id="gender" name="gender" value="<?= isset($_SESSION['oldGender']) ? $_SESSION['oldGender'] : ''; unset($_SESSION['oldGender']);?>" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" >
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
                    <input type="date" id="birth" name="birth" value="<?= isset($_SESSION['oldBirth']) ? $_SESSION['oldBirth'] : ''; unset($_SESSION['oldBirth']);?>" class="p-1.5 text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" >
                    <?php if(isset($_SESSION['birthError'])): ?>
                        <p class="text-end text-xs"><?= $_SESSION['birthError']; ?></p>
                        <?php unset($_SESSION['birthError']); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if(isset($_SESSION['error'])): ?>
                <p class="text-center"><?= $_SESSION['error'] ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <button type="submit" name="register" class="py-2 px-5 w-fit bg-white text-black text-xl rounded-lg transition duration-300 hover:bg-gray-200">Sign Up</button>
        </div>
    </form>
</main>
<?php include('templates/foot.php'); ?>