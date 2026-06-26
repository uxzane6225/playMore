<?php
require __DIR__ . '/../processors/auth/auth.php';
$tid = $_GET['tid'];

if (empty($tid)) {
    header("Location: store.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE t.tid = ?");
$stmt->execute([$tid]);
$toy = $stmt->fetch();

$others = $pdo->query("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid ORDER BY t.createDateTime DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/head.php';
include 'templates/navbar.php';
?>
<main class="p-5 flex flex-col gap-5">
    <a href="shop.php" class="w-full lg:w-fit py-2 px-5 bg-red-600 text-center text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Go Back</a>
    
    <section class="flex flex-col lg:flex-row gap-2 ">
        <img src="../storage/images/toys/<?= $toy['imagepath'] ?>" alt="Image of Toy" class="p-2 w-96 h-96 bg-red-600 rounded-xl object-contain">
        <div class="px-2 lg:py-2 flex flex-col gap-2">
            <h2 class="text-xl font-bold text-center lg:text-start"><?= $toy['name'] ?></h2>
            <div class="flex flex-col gap-2">
                <div class="flex gap-5">
                    <p><strong>Stock:</strong> <?= $toy['stock'] ?></p>
                    <p><strong>Age Range:</strong> <?= $toy['min_age'] ?> - <?= $toy['max_age'] ?></p>
                </div>
                
                <div>
                    <p><strong>Brand:</strong> <?= $toy['brand'] ?></p>
                    <p><strong>Category:</strong> <?= $toy['category'] ?></p>
                    <p><strong>Type:</strong> <?= $toy['type'] ?></p>
                </div>
            </div>
            <!-- <form action="">
                <button type="submit" name="purchase" class="w-full lg:w-fit py-2 px-5 bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Purchase ($<?= $toy['price'] ?>)</button>
            </form> -->
            <button id="purchase" class="w-full lg:w-fit py-2 px-5 bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Purchase ($<?= $toy['price'] ?>)</button>
            <div>
                <h3 class="font-bold">Description</h3>
                <p class="text-gray-500"><?= $toy['description'] ?></p>
            </div>
        </div>
    </section>
    <section class="p-5">
        <h2 class="text-3xl font-bold">Other Toys</h2>
        <div class="flex flex-col lg:grid grid-cols-5 gap-5 items-center justify-center">
            <?php if(count($others) !== 0 ): ?>
                <?php foreach($others as $other): ?>
                    <article class="p-5 flex flex-col gap-2 bg-white rounded-xl shadow-lg">
                        <img src="../storage/images/toys/<?= $other['imagepath'] ?>" alt="Toy Picture <?= $other['tid'] ?>" class="self-center h-72 w-72 border border-2 border-red-600 rounded-xl object-cover">
                        <div class="h-full flex flex-col gap-2 lg:justify-between">
                            <div>
                                <h3 class="text-lg font-bold"><?= $other['name'] ?></h3>
                                <p class="text-yellow-700">$<?= $other['price'] ?></p>
                            </div>
                            <a href="buy.php?tid=<?= $other['tid'] ?>" class="w-full py-2 px-5 bg-red-600 text-center text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Buy</a>
                        </div>
                    </article>  
                <?php endforeach; ?>
            <?php else: ?>
                <h1 class="text-2xl font-bold">Nothing!</h1>
                <p>It seems like we are experiencing a whole load of nothing!</p>
            <?php endif; ?>
        </div>
    </section>
    <dialog id="modal" class="p-10 text-center rounded-xl">
        <h2 class="mb-1 text-2xl text-green-500 font-bold">Purchase Successful!</h2>
        <p class="mb-5">No, this doesn't work, because I stupidly designed the sales table with POS in mind.</p>
        <button id="close" class="w-full py-2 px-5 text-xl bg-gray-200 transition duration-300 rounded-lg hover:bg-gray-300">Close</button>
    </dialog>
</main>
<footer class="p-5 w-full bg-red-600 text-white">
    <p><span class="font-bold">&copy;</span> Uriel Laurence M. Mendoza | 2nd Year - 3rd Trimester | ITWS Finals Project</p>
</footer>
<script>
    let modal = document.getElementById('modal');
    let purchase = document.getElementById('purchase');
    let confirmBtn = document.getElementById('confirmBtn');
    let close = document.getElementById('close');

    purchase.addEventListener('click', e => {
        modal.showModal();
        modal.classList.remove('hidden');
    });

    close.addEventListener('click', e => {
        modal.close();
        modal.classList.add('hidden');
    });
</script>
<?php include('templates/foot.php'); ?>