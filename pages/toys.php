<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Toys";

include('templates/adminHead.php');
include('templates/adminNavbar.php');

$stmt = $pdo->query('SELECT t.tid, t.name, t.description, b.brand, b.bid, tt.type, tt.ttid, tc.category, tc.tcid, t.min_age, t.max_age, t.price, t.stock, a.fullname, a.aid, t.createDateTime, t.updateDateTime FROM toys t INNER JOIN accounts a ON a.aid = t.aid INNER JOIN toytypes tt ON tt.ttid = t.ttid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN brands b ON b.bid = t.bid');
$stmt->execute();
$toys = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Toys</h2>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php elseif(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </div>
    <div class="h-full w-full text-sm bg-gray-200 overflow-auto border border-b-4 rounded-t-2xl border-b-red-600">
        <table class="w-full">
            <thead class="text-white bg-red-700">
                <th class="p-1 lg:p-3">ID</th>
                <th class="p-1 lg:p-3">Name</th>
                <!-- <th class="p-1 lg:p-3">Description</th> -->
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
                    <tr class="text-center border border-b-gray-400 even:bg-gray-300">
                        <td class="p-1"><?= $toy['tid'] ?></td>
                        <td class="p-1"><?= htmlspecialchars($toy['name']) ?></td>
                        <!-- <td class="p-1"><?= htmlspecialchars($toy['description']) ?></td> -->
                        <td class="p-1"><?= htmlspecialchars($toy['brand']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($toy['type']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($toy['category']) ?></td>
                        <td class="p-1">
                            <?= $toy['min_age'] ?> - <?= $toy['max_age'] ?>
                        </td>
                        <td class="p-1"><?= htmlspecialchars($toy['price']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($toy['stock']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($toy['fullname']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($toy['createDateTime']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($toy['updateDateTime']) ?></td>
                        <td class="p-1 flex flex-col justify-center gap-2 border border-l-gray-400">
                            <!-- <div class="flex flex-col gap-2"> -->
                                <a href="toys/edit.php?tid=<?= $toy['tid'] ?>" class="py-1 px-5 bg-yellow-300 rounded-lg transition duration-300 hover:bg-yellow-400">Edit</a>
                                <!-- <form action="../processors/toys/delete.php" method="POST">
                                    <button type="submit" name="delete" value="<?= $toy['tid'] ?>" class="py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                                </form> -->
                                <button type="submit" value="<?= $toy['tid'] ?>" class="deleteBtn py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                            <!-- </div> -->
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
    <dialog id="modal" class="p-5 flex flex-col gap-5 text-center rounded-lg hidden">
        <h3 class="text-xl font-bold">Delete this Toy?</h3>
        <div class="flex gap-5">
            <form action="../processors/toys/delete.php" method="POST">
                <button id="confirmBtn" name="delete" class="py-1 px-5 text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Confirm</button>
            </form>
            <button id="cancel" class="py-1 px-5 bg-gray-300 rounded-lg transition duration-300 hover:bg-gray-200">Cancel</button>
        </div>
    </dialog>
</main>
<script>
    let modal = document.getElementById('modal');
    let deleteBtn = document.querySelectorAll('.deleteBtn');
    let confirmBtn = document.getElementById('confirmBtn');
    let cancel = document.getElementById('cancel');
    
    deleteBtn.forEach(dlt => {
        dlt.addEventListener('click', e => {
            modal.showModal();
            modal.classList.remove('hidden');
            let user_id = dlt.value;
            confirmBtn.value = user_id;
        });
    });

    cancel.addEventListener('click', e => {
        modal.close();
        modal.classList.add('hidden');
        let user_id = deleteBtn.value;
        confirmBtn.value = user_id;
    });
</script>
<?php include('templates/foot.php'); ?>