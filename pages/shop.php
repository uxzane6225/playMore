<?php
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Shop";

$brands = $pdo->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
$categories = $pdo->query("SELECT * FROM toycategories")->fetchAll(PDO::FETCH_ASSOC);
$types = $pdo->query("SELECT * FROM toytypes")->fetchAll(PDO::FETCH_ASSOC);

$toys = $pdo->query("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/head.php';
include 'templates/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['apply'])) {

    }
}

?>
<main class="w-full lg:h-full flex flex-col lg:grid grid-cols-5 gap-6">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET" class="m-5 p-5 h-fit lg:w-full flex flex-col gap-5 text-white bg-red-600 rounded-lg shadow-xl">
        <header>
            <h2 class="text-2xl font-bold">Filters</h2>
        </header>
        <div>
            <label for="brand"><h3>Brands</h3></label>
            <select name="brand" id="brand" class="p-2 w-full text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php foreach($brands as $brand): ?>
                    <option value="<?= $brand['bid'] ?>"><?= $brand['brand'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="category"><h3>Category</h3></label>
            <select name="category" id="category" class="p-2 w-full text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category['tcid'] ?>"><?= $category['category'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="type"><h3>Type</h3></label>
            <select name="type" id="type" class="p-2 w-full text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php foreach($types as $type): ?>
                    <option value="<?= $type['ttid'] ?>"><?= $type['type'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="py-2 px-5 bg-white text-black text-xl rounded-lg transition duration-300 hover:bg-gray-100">Apply</button>
    </form>
    <section class="p-10 flex flex-col items-center col-span-4">
        <?php foreach($toys as $toy): ?>
            <article class="p-5 lg:w-full flex flex-col lg:flex-row gap-2 bg-white rounded-xl shadow-lg">
                <img src="../storage/images/toys/<?= $toy['imagepath'] ?>" alt="Toy Picture" class="h-72 w-72 border border-2 border-red-600 rounded-xl ">
                <div class="h-full flex flex-col gap-2 lg:justify-between">
                    <div>
                        <h3 class="text-lg font-bold"><?= $toy['name'] ?></h3>
                        <p class="hidden lg:block text-sm text-gray-500"><?= $toy['description'] ?></p>
                        <p class="text-yellow-500">$<?= $toy['price'] ?></p>
                    </div>
                    <form method="POST "class="w-full lg:w-fit">
                        <button type="submit" name="buy" value="<?= $toy['tid'] ?>" class="w-full lg:w-fit py-2 px-5 bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Buy</button>
                    </form>
                    <div class="hidden lg:flex gap-2 text-xs">
                        <p class="p-1 text-white bg-red-600 rounded-lg"><?= $toy['brand'] ?></p>
                        <p class="p-1 text-white bg-red-600 rounded-lg"><?= $toy['category'] ?></p>
                        <p class="p-1 text-white bg-red-600 rounded-lg"><?= $toy['type'] ?></p>
                    </div>
                </div>
            </article>  
        <?php endforeach; ?>
    </section>
    <!-- <h1 class="text-2xl font-bold">Under Construction!</h1>
    <p>This part of the website is still unfinished.</p> -->
</main>
<footer class="p-5 w-full bg-red-600 text-white">
    <p><span class="font-bold">&copy;</span> Uriel Laurence M. Mendoza | 2nd Year - 3rd Trimester | ITWS Finals Project</p>
</footer>
<?php include('templates/foot.php'); ?>