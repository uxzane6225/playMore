<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Toys";

include('templates/adminHead.php');
include('templates/adminNavbar.php');

$stmt = $pdo->query('SELECT * FROM toys t INNER JOIN accounts a ON a.aid = t.aid INNER JOIN toytypes tt ON tt.ttid = t.ttid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN brands b ON b.bid = t.bid');
$stmt->execute();
$toys = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <h2 class="text-4xl font-bold">Toys</h2>
    <div class="h-full w-full bg-gray-200 overflow-scroll border border-b-4 rounded-t-2xl border-b-red-600">
        <table class="w-full">
            <thead class="text-white bg-red-700">
                <th class="p-1 lg:p-3">ID</th>
                <th class="p-1 lg:p-3">Name</th>
                <th class="p-1 lg:p-3">Description</th>
                <th class="p-1 lg:p-3">Brand</th>
                <th class="p-1 lg:p-3">Type</th>
                <th class="p-1 lg:p-3">Category</th>
                <th class="p-1 lg:p-3">Range</th>
                <th class="p-1 lg:p-3">Price</th>
                <th class="p-1 lg:p-3">Stock</th>
                <th class="p-1 lg:p-3">Interaction</th>
                <th class="p-1 lg:p-3">Created</th>
                <th class="p-1 lg:p-3">Updated</th>
                <th class="p-1 lg:p-3">Action</th>
            </thead>
            <tbody>
                <?php foreach($toys as $toy): ?>
                    <tr>
                        <td><?= $toy['tid'] ?></td>
                        <td><?= htmlspecialchars($toy['name']) ?></td>
                        <td><?= htmlspecialchars($toy['description']) ?></td>
                        <td><?= htmlspecialchars($toy['bi']) ?></td>
                        <td><?= htmlspecialchars($toy['ttid']) ?></td>
                        <td><?= htmlspecialchars($toy['tcid']) ?></td>
                        <td>
                            <?= $toy['min_age'] ?> - <?= $toy['max_age'] ?>
                        </td>
                        <td><?= htmlspecialchars($toy['price']) ?></td>
                        <td><?= htmlspecialchars($toy['stock']) ?></td>
                        <td><?= htmlspecialchars($toy['aid']) ?></td>
                        <td><?= htmlspecialchars($toy['createdDateTime']) ?></td>
                        <td><?= htmlspecialchars($toy['updatedDateTime']) ?></td>
                        <td>
                            <a href="toys/edit.php">Details</a>
                            <form action="../processors/toys/delete.php" method="POST">
                                <button type="submit" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="grid grid-cols-2 gap-2 text-center lg:flex">
        <a href="toys/add.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Add Toy</a>
        <a href="brands.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Brands</a>
        <a href="categories.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Categories</a>
        <a href="types.php" class="py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Types</a>
    </div>
</main>
<?php include('templates/foot.php'); ?>