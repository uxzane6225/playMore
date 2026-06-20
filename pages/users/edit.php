<?php 
require __DIR__ . '/../../processors/auth/auth.php';
$_SESSION['title'] = "Ediit Admin/Staff";

include '../templates/adminHead.php';
include '../templates/adminNavbar.php';

?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Create Admin/Staff</h2>
        <?php if(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php elseif(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
    <form action="../../processors/users/edit.php" method="POST" class="flex flex-col text-md gap-3">
        <div class="flex flex-col gap-1">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" value="<?= isset($_SESSION['oldName']) ? $_SESSION['oldName'] : ''; unset($_SESSION['oldName']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['nameError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['nameError']; ?></p>
                <?php unset($_SESSION['nameError']); ?>
            <?php endif; ?>
        </div>
        <div class="flex flex-col gap-1">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" value="<?= isset($_SESSION['oldEmail']) ? $_SESSION['oldEmail'] : ''; unset($_SESSION['oldEmail']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['emailError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['emailError']; ?></p>
                <?php unset($_SESSION['emailError']); ?>
            <?php endif; ?>
        </div>

         <div class="flex flex-col gap-1">
            <label for="phone">Phone #</label>
            <input type="text" name="phone" id="phone" value="<?= isset($_SESSION['oldPhone']) ? $_SESSION['oldPhone'] : ''; unset($_SESSION['oldPhone']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['phoneError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['phoneError']; ?></p>
                <?php unset($_SESSION['phoneError']); ?>
            <?php endif; ?>
        </div>

         <div class="flex flex-col gap-1">
            <label for="home">Home Address</label>
            <input type="text" name="home" id="home" value="<?= isset($_SESSION['oldHome']) ? $_SESSION['oldHome'] : ''; unset($_SESSION['oldHome']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['homeError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['homeError']; ?></p>
                <?php unset($_SESSION['homeError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-1">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['passError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['passError']; ?></p>
                <?php unset($_SESSION['passError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-1">
            <label for="confirm">Confirm Password</label>
            <input type="password" name="confirm" id="confirm"  class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['confirmError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['confirmError']; ?></p>
                <?php unset($_SESSION['confirmError']); ?>
            <?php endif; ?>
        </div>
        <div class="flex flex-col gap-1">
            <label for="role">Role</label>
            <select name="role" id="role" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
            </select>
            <?php if(isset($_SESSION['addressError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['addressError']; ?></p>
                <?php unset($_SESSION['addressError']); ?>
            <?php endif; ?>
        </div>
        <div>
            <button class="py-1 px-5 w-fit bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Edit</button>
            <a href="../users.php" class="py-1 px-5 w-fit bg-gray-400 text-white text-xl rounded-lg transition duration-300 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</main>
<?php include '../templates/foot.php'; ?>