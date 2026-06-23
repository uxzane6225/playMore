<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Sales";

include('templates/adminHead.php');
include('templates/adminNavbar.php');

$stmt = $pdo->query('SELECT s.sid, caid.fullname AS "customer", eaid.fullname AS "staff", s.total_cost, s.sale_datetime FROM sales s INNER JOIN accounts caid ON caid.aid = s.cid INNER JOIN accounts eaid ON eaid.aid = s.eid');
$stmt->execute();
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Sales</h2>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php elseif(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    </div>
    <div class="h-full w-full text-sm bg-gray-200 overflow-scroll border border-b-4 rounded-t-2xl border-b-red-600">
        <table class="w-full">
            <thead class="text-white bg-red-700">
                <th class="p-1 lg:p-3">ID</th>
                <th class="p-1 lg:p-3">Customer</th>
                <th class="p-1 lg:p-3">Employee</th>
                <th class="p-1 lg:p-3">Total Cost</th>
                <th class="p-1 lg:p-3">Transaction Date-Time</th>
                <th class="p-1 lg:p-3">Action</th>
            </thead>
            <tbody>
                <?php foreach($sales as $sale): ?>
                    <tr class="text-center border border-b-gray-400 even:bg-gray-300">
                        <td class="p-1"><?= $sale['sid'] ?></td>
                        <td class="p-1"><?= htmlspecialchars($sale['customer']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($sale['staff']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($sale['total_cost']) ?></td>
                        <td class="p-1"><?= htmlspecialchars($sale['sale_datetime']) ?></td>
                        <td class="p-1 flex flex-col justify-center gap-2 border border-l-gray-400">
                            <!-- <div class="flex flex gap-2"> -->
                            <a href="details.php?sid=<?= $sale['sid'] ?>" class="py-1 px-5 bg-yellow-300 rounded-lg transition duration-300 hover:bg-yellow-400">Detail</a>
                            <!-- <form action="../processors/sales/delete.php" method="POST">
                                <button type="submit" name="delete" value="<?= $sale['sid'] ?>" class="py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                            </form> -->
                            <!-- </div> -->
                             <button type="submit" value="<?= $sale['sid'] ?>" class="deleteBtn py-1 px-5 w-full h-full text-white bg-red-600 rounded-lg transition duration-300 hover:bg-red-500">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="sales/add.php" class="w-fit py-2 px-5 text-white bg-red-600 rounded-xl transition duration-300 hover:bg-red-500">Add Sales</a>
    <dialog id="modal" class="p-5 flex flex-col gap-5 text-center rounded-lg hidden">
        <h3 class="text-xl font-bold">Delete this Sale?</h3>
        <div class="flex gap-5">
            <form action="../processors/sales/delete.php" method="POST">
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