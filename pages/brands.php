<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Brands";

include('templates/adminHead.php');
include('templates/adminNavbar.php');

$stmt = $pdo->query('SELECT * FROM brands ORDER BY bid DESC');
$stmt->execute();
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Brands</h2>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php elseif(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </div>
    <div class="grid grid-cols-2 gap-2 text-center lg:flex">
        <a href="brands/add.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Add Brand</a>
        <a href="toys.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Toys</a>
        <a href="categories.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Categories</a>
        <a href="types.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Types</a>
    </div>
    <div class="h-full w-full text-sm bg-gray-200 overflow-scroll lg:overflow-hidden border border-b-4 rounded-t-2xl border-b-red-600">
        <table class="w-full">
            <thead class="text-white bg-red-700">
                <th class="p-1 lg:p-3">ID</th>
                <th class="p-1 lg:p-3">Brand</th>
                <th class="p-1 lg:p-3">Action</th>
            </thead>
            <tbody>
                <?php foreach($brands as $brand): ?>
                    <tr class="text-center border border-b-gray-400 even:bg-gray-300">
                        <td class="p-1"><?= htmlspecialchars($brand['bid']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($brand['brand']) ?></td>
                        <td class="p-1 flex flex-col lg:flex-row justify-center gap-2 border border-l-gray-400">
                            <a href="brands/edit.php?bid=<?= $brand['bid'];?>" class="py-1 px-5 bg-yellow-300 rounded-lg transition duration-300 hover:bg-yellow-400">Edit</a>
                            <!-- <form action="../processors/brands/delete.php" method="POST">
                                <button type="submit" name="delete" value="<?= $brand['bid'] ?>" class="py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                            </form> -->
                            <button type="submit" value="<?= $brand['bid'] ?>" class="deleteBtn py-1 px-5 text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                            <!-- <button type="submit" value="<?= $brand['bid'] ?>" class="deleteBtn py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <dialog id="modal" class="p-5 flex flex-col gap-5 text-center rounded-lg hidden">
        <h3 class="text-xl font-bold">Delete this Brand?</h3>
        <div class="flex gap-5">
            <form action="../processors/brands/delete.php" method="POST">
                <button id="confirmBtn" name="delete" class="py-1 px-5 text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Confirm</button>
            </form>
            <button id="cancel" class="py-1 px-5 bg-gray-300 rounded-lg transition duration-300 hover:bg-gray-200">Cancel</button>
        </div>
    </dialog>
</main>
<script src="../scripts/deleteModal.js"></script>
<?php include('templates/foot.php'); ?>