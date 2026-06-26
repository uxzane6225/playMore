<?php 
require __DIR__ . '/../../processors/auth/auth.php';
$_SESSION['title'] = "Add Detail";

include '../templates/adminHead.php';
include '../templates/adminNavbar.php';

$sid = $_GET['sid'] ?? '';

$toys = $pdo->query("SELECT * FROM toys");
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <h2 class="text-4xl font-bold">Add Detail</h2>
    <form action="../../processors/details/add.php" method="POST" class="flex flex-col text-xl gap-2">
        <input type="text" name="sid" value="<?= $sid ?>" hidden>
        <div class="flex flex-col gap-1">
            <label for="product">Product</label>
            <select name="product" id="product" value="<?= isset($_SESSION['oldProduct']) ? $_SESSION['oldProduct'] : ''; unset($_SESSION['oldProduct']); ?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php foreach($toys as $toy): ?>
                    <option value="<?= $toy['tid'] ?>"><?= $toy['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php if(isset($_SESSION['productError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['productError']; ?></p>
                <?php unset($_SESSION['productError']); ?>
            <?php elseif(isset($_SESSION['success'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
        </div>
        <div class="flex flex-col gap-1">
            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" value="<?= isset($_SESSION['oldQuantity']) ? $_SESSION['oldQuantity'] : '1'; unset($_SESSION['oldQuantity']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['quantityError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['quantity']; ?></p>
                <?php unset($_SESSION['quantity']); ?>
            <?php elseif(isset($_SESSION['success'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
        </div>
        <div>
            <button class="py-1 px-5 w-fit bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Add</button>
            <a href="../details.php?sid=<?= $sid ?>" class="py-1 px-5 w-fit bg-gray-200 text-xl rounded-lg transition duration-300 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</main>
<?php include '../templates/foot.php'; ?>