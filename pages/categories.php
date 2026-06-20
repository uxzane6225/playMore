<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Categories";

include('templates/adminHead.php');
include('templates/adminNavbar.php');

$stmt = $pdo->query('SELECT * FROM toycategories ORDER BY tcid DESC');
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Categories</h2>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php elseif(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </div>
    <div class="h-full w-full bg-gray-200 overflow-scroll border border-b-4 rounded-t-2xl border-b-red-600">
        <table class="w-full">
            <thead class="text-white bg-red-700">
                <th class="p-1 lg:p-3">ID</th>
                <th class="p-1 lg:p-3">Category</th>
                <th class="p-1 lg:p-3">Action</th>
            </thead>
            <tbody>
                <?php foreach($categories as $category): ?>
                    <tr>
                        <td class="p-1 text-center"><?= htmlspecialchars($category['tcid']) ?></td>
                        <td class="p-1 text-center"><?= htmlspecialchars($category['category']) ?></td>
                        <td class="p-1 flex justify-center gap-2">
                            <a href="categories/edit.php?tcid=<?= $category['tcid'];?>" class="py-1 px-5 bg-yellow-300 rounded-lg transition duration-300 hover:bg-yellow-400">Edit</a>
                            <form action="../processors/categories/delete.php" method="POST">
                                <button type="submit" name="delete" value="<?= $category['tcid'] ?>" class="py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="grid grid-cols-2 gap-2 text-center lg:flex">
        <a href="categories/add.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Add Category</a>
        <a href="toys.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Toys</a>
        <a href="brands.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Brands</a>
        <a href="types.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Types</a>
    </div>
</main>
<?php include('templates/foot.php'); ?>