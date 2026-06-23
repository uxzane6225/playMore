<?php 
require __DIR__ . '/../../processors/auth/auth.php';
$_SESSION['title'] = "Add Sale";

include '../templates/adminHead.php';
include '../templates/adminNavbar.php';

$customers = $pdo->query("SELECT * FROM accounts WHERE role = 'user'");
$employees = $pdo->query("SELECT * FROM accounts WHERE role = 'staff'");
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <h2 class="text-4xl font-bold">Add Sale</h2>
    <form action="../../processors/sales/add.php" method="POST" class="flex flex-col text-xl gap-2">
        <div class="flex flex-col gap-1">
            <label for="customer">Customer</label>
            <select name="customer" id="customer" value="<?= isset($_SESSION['oldCustomer']) ? $_SESSION['oldCustomer'] : ''; unset($_SESSION['oldCustomer']); ?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php foreach($customers as $customer): ?>
                    <option value="<?= $customer['aid'] ?>"><?= $customer['fullname'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php if(isset($_SESSION['customerError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['customerError']; ?></p>
                <?php unset($_SESSION['customerError']); ?>
            <?php elseif(isset($_SESSION['success'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
        </div>
        <div class="flex flex-col gap-1">
            <label for="total">Total Cost</label>
            <input type="number" id="total" name="total" value="<?= isset($_SESSION['oldTotal']) ? $_SESSION['oldTotal'] : '0.00'; unset($_SESSION['oldTotal']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['totalError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['totalError']; ?></p>
                <?php unset($_SESSION['totalError']); ?>
            <?php elseif(isset($_SESSION['success'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['success']; ?></p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
        </div>
        <div>
            <button class="py-1 px-5 w-fit bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Add</button>
            <a href="../sales.php" class="py-1 px-5 w-fit bg-gray-400 text-white text-xl rounded-lg transition duration-300 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</main>
<?php include '../templates/foot.php'; ?>