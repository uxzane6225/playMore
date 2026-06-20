<?php 
require __DIR__ . '/../../processors/auth/auth.php';
$_SESSION['title'] = "Add Brand";

include '../templates/adminHead.php';
include '../templates/adminNavbar.php';
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <h2 class="text-4xl font-bold">Add Brand</h2>
    <form action="../../processors/brands/add.php" method="POST" class="flex flex-col text-xl gap-2">
        <label for="brand">Brand</label>
        <input type="text" name="brand" id="brand" value="<?= isset($_SESSION['oldBrand']) ? $_SESSION['oldBrand'] : ''; unset($_SESSION['oldBrand']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
        <?php if(isset($_SESSION['brandError'])): ?>
            <p class="text-end text-xs"><?= $_SESSION['brandError']; ?></p>
            <?php unset($_SESSION['brandError']); ?>
        <?php elseif(isset($_SESSION['error'])): ?>
            <p class="text-end text-xs"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php elseif(isset($_SESSION['success'])): ?>
            <p class="text-end text-xs"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <div>
            <button class="py-1 px-5 w-fit bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Add</button>
            <a href="../brands.php" class="py-1 px-5 w-fit bg-gray-400 text-white text-xl rounded-lg transition duration-300 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</main>
<?php include '../templates/foot.php'; ?>