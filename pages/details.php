<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Sale Details";

include('templates/adminHead.php');
include('templates/adminNavbar.php');

$sid = $_GET['sid'] ?? '';

$stmt = $pdo->prepare('SELECT * FROM sale_details sd INNER JOIN sales s ON s.sid = sd.sid INNER JOIN toys t ON sd.tid = t.tid WHERE s.sid = ?');
$stmt->execute([$sid]);
$details = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Details</h2>
        <p>Sale ID: <?= $sid ?></p>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php elseif(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </div>
    <a href="details/add.php?sid=<?= $sid ?>" class="w-fit py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Add Detail</a>
    <div class="h-full w-full text-sm bg-gray-200 overflow-scroll lg:overflow-hidden border border-b-4 rounded-t-2xl border-b-red-600">
        <table class="w-full">
            <thead class="text-white bg-red-700">
                <th class="p-1 lg:p-3">ID</th>
                <th class="p-1 lg:p-3">Sale ID</th>
                <th class="p-1 lg:p-3">Toy</th>
                <th class="p-1 lg:p-3">Quantity</th>
                <th class="p-1 lg:p-3">Total</th>
                <th class="p-1 lg:p-3">Action</th>
            </thead>
            <tbody>
                <?php foreach($details as $detail): ?>
                    <tr class="text-center border border-b-gray-400 even:bg-gray-300">
                        <td class="p-1"><?= $detail['sdid'] ?></td>
                        <td class="p-1"><?= htmlspecialchars($detail['sid']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($detail['name']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($detail['quantity']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($detail['total']) ?></td>
                        <td class="p-1 flex flex-col justify-center gap-2 border border-l-gray-400">
                            <!-- <div class="flex flex gap-2"> -->
                            <a href="details/edit.php?sdid=<?= $detail['sdid'] ?>" class="py-1 px-5 bg-yellow-300 rounded-lg transition duration-300 hover:bg-yellow-400">Edit</a>
                            <form action="../processors/details/delete.php" method="POST">
                                <button type="submit" name="delete" value="<?= $detail['sdid'] ?>" class="py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                            </form>
                            <!-- </div> -->
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include('templates/foot.php'); ?>