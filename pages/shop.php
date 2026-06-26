<?php
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Shop";

$brands = $pdo->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
$categories = $pdo->query("SELECT * FROM toycategories")->fetchAll(PDO::FETCH_ASSOC);
$types = $pdo->query("SELECT * FROM toytypes")->fetchAll(PDO::FETCH_ASSOC);

$toys = $pdo->query("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid ORDER BY t.createDateTime DESC")->fetchAll(PDO::FETCH_ASSOC);

include 'templates/head.php';
include 'templates/navbar.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['apply'])) {
        $search = '%' . $_GET['search'] . '%';
        $brandFilter = $_GET['brand'];
        $categoryFilter = $_GET['category'];
        $typeFilter = $_GET['type'];

        if (empty($brandFilter) && empty($categoryFilter) && empty($typeFilter)) {

            if (empty($_GET['search'])) {
                header("Location: " . $_SERVER['PHP_SELF']);
            }
            else {
                $stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE name LIKE ? ORDER BY t.createDateTime DESC");
                $stmt->execute([$search]);    
            }
        }
        else {
            if (empty($brandFilter) && empty($categoryFilter)) {
                $stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE tt.ttid = ? AND name LIKE ? ORDER BY t.createDateTime DESC");
                $stmt->execute([$typeFilter, $search]);    
            }
            else if (empty($brandFilter) && empty($typeFilter)) {
                $stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE tc.tcid = ? AND name LIKE ? ORDER BY t.createDateTime DESC");
                $stmt->execute([$categoryFilter, $search]);    
            }
            else if (empty($categoryFilter) && empty($typeFilter)) {
                $stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE b.bid = ? AND name LIKE ? ORDER BY t.createDateTime DESC");
                $stmt->execute([$brandFilter, $search]);    
            }
            else if (empty($brandFilter)) {
                $stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE tc.tcid = ? AND tt.ttid = ? AND name LIKE ? ORDER BY t.createDateTime DESC");
                $stmt->execute([$categoryFilter, $typeFilter, $search]);    
            }
            else if (empty($categoryFilter)) {
                $stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE b.bid = ? AND tt.ttid = ? AND name LIKE ? ORDER BY t.createDateTime DESC");
                $stmt->execute([$brandFilter, $typeFilter, $search]);
            }
            else if (empty($typeFilter)) {
                $stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE b.bid = ? AND tc.tcid = ? AND name LIKE ? ORDER BY t.createDateTime DESC");
                $stmt->execute([$brandFilter, $categoryFilter, $search]);
            }
            else {
                $stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE b.bid = ? AND tc.tcid = ? AND tt.ttid = ? AND name LIKE ? ORDER BY t.createDateTime DESC");
                $stmt->execute([$brandFilter, $categoryFilter, $typeFilter, $search]);
            }
        }
        $toys = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if (isset($_GET['clear'])) {
        unset($_GET['apply']);
        unset($_GET['brand']);
        unset($_GET['category']);
        unset($_GET['type']);

        header("Location: " . $_SERVER['PHP_SELF']);
    }
}
?>
<main class="w-full <?= count($toys) === 0 ? "lg:h-full" :  ""; ?> flex flex-col lg:grid grid-cols-5 gap-6">
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="GET" class="m-5 p-5 h-fit lg:w-full flex flex-col gap-5 text-white bg-red-600 rounded-lg shadow-xl">
        <header>
            <h1 class="text-2xl font-bold">Filters</h1>
        </header>
        <div>
            <label for="search">Search</label>
            <input type="text" id="search" name="search" class="p-2 w-full text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" placeholder="Search">
        </div>
        <div>
            <label for="brand"><h2>Brands</h2></label>
            <select name="brand" id="brand" class="p-2 w-full text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <option value="">Select</option>
                <?php foreach($brands as $brand): ?>
                    <option value="<?= $brand['bid'] ?>"><?= $brand['brand'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="category"><h2>Category</h2></label>
            <select name="category" id="category" class="p-2 w-full text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <option value="">Select</option>
                <?php foreach($categories as $category): ?>
                    <option value="<?= $category['tcid'] ?>"><?= $category['category'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="type"><h2>Type</h2></label>
            <select name="type" id="type" class="p-2 w-full text-black rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <option value="">Select</option>
                <?php foreach($types as $type): ?>
                    <option value="<?= $type['ttid'] ?>"><?= $type['type'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button name="apply" class="py-2 px-5 bg-white text-black text-xl rounded-lg transition duration-300 hover:bg-gray-100">Apply</button>
        <button name="clear" class="py-2 px-5 bg-white text-black text-xl rounded-lg transition duration-300 hover:bg-gray-100">Clear</button>
    </form>
    
    <section class="p-10 flex flex-col h-fit lg:grid grid-cols-3 col-span-4 gap-5 lg:gap-10">
        <?php if(count($toys) !== 0 ): ?>
            <?php foreach($toys as $toy): ?>
                <article class="p-5 flex flex-col gap-2 bg-white rounded-xl shadow-lg">
                    <img src="../storage/images/toys/<?= $toy['imagepath'] ?>" alt="Toy Picture <?= $toy['tid'] ?>" class="self-center h-72 w-72 border border-2 border-red-600 rounded-xl object-cover">
                    <div class="h-full flex flex-col gap-2 lg:justify-between">
                        <div>
                            <h3 class="text-lg font-bold"><?= $toy['name'] ?></h3>
                            <p class="text-yellow-700">$<?= $toy['price'] ?></p>
                        </div>
                        <div class="w-full flex flex-col gap-3">
                            <a href="buy.php?tid=<?= $toy['tid'] ?>" class="w-full py-2 px-5 bg-red-600 text-center text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Buy</a>
                            <div class="w-full hidden lg:flex justify-center gap-2 text-xs">
                                <p class="py-1 px-2 text-white bg-red-600 rounded-lg"><?= $toy['brand'] ?></p>
                                <p class="py-1 px-2 text-white bg-red-600 rounded-lg"><?= $toy['category'] ?></p>
                                <p class="py-1 px-2 text-white bg-red-600 rounded-lg"><?= $toy['type'] ?></p>
                            </div>
                        </div>
                    </div>
                </article>  
            <?php endforeach; ?>
        <?php else: ?>
            <h1 class="text-2xl font-bold">Nothing!</h1>
            <p>It seems like we are experiencing a whole load of nothing!</p>
        <?php endif; ?>
    </section>
</main>
<footer class="p-5 w-full bg-red-600 text-white">
    <p><span class="font-bold">&copy;</span> Uriel Laurence M. Mendoza | 2nd Year - 3rd Trimester | ITWS Finals Project</p>
</footer>
<?php include('templates/foot.php'); ?>