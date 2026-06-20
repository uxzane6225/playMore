<?php 
require __DIR__ . '/../../processors/auth/auth.php';
$_SESSION['title'] = "Edit Category";

include '../templates/adminHead.php';
include '../templates/adminNavbar.php';
$tcid = $_GET['tcid'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM toycategories WHERE tcid = ?");
$stmt->execute([$tcid]);

$category = $stmt->fetch();

if (!$category) {
    $_SESSION['error'] = "Category not found!";
    header("Location: ../categories.php");
    exit;
}

$_SESSION['tcid'] = $category['tcid'];
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <h2 class="text-4xl font-bold">Edit Toy Type</h2>
    <form action="../../processors/categories/edit.php" method="POST" class="flex flex-col text-xl gap-2">
        <label for="category">Type</label>
        <input type="text" name="category" id="category" value="<?= $category['category'];?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
        <?php if(isset($_SESSION['categoryError'])): ?>
            <p class="text-end text-xs"><?= $_SESSION['categoryError']; ?></p>
            <?php unset($_SESSION['categoryError']); ?>
        <?php elseif(isset($_SESSION['error'])): ?>
            <p class="text-end text-xs"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php elseif(isset($_SESSION['success'])): ?>
            <p class="text-end text-xs"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <div>
            <button class="py-1 px-5 w-fit bg-yellow-400 text-white text-xl rounded-lg transition duration-300 hover:bg-yellow-500">Edit</button>
            <a href="../categories.php" class="py-1 px-5 w-fit bg-gray-400 text-white text-xl rounded-lg transition duration-300 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</main>
<?php include '../templates/foot.php'; ?>