<?php 
require __DIR__ . '/../../processors/auth/auth.php';
$_SESSION['title'] = "Toy Details";

include '../templates/adminHead.php';
include '../templates/adminNavbar.php';

$tid = $_GET['tid'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM toys t INNER JOIN brands b ON b.bid = t.bid INNER JOIN toycategories tc ON tc.tcid = t.tcid INNER JOIN toytypes tt ON tt.ttid = t.ttid WHERE tid = ?");
$stmt->execute([$tid]);

$toy = $stmt->fetch();

if (!$toy) {
    $_SESSION['error'] = "Toy Type not found!";
    header("Location: ../types.php");
    exit;
}

$_SESSION['tid'] = $toy['tid'];

$categories = $pdo->query("SELECT * FROM toycategories")->fetchAll(PDO::FETCH_ASSOC);
$brands = $pdo->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
$types = $pdo->query("SELECT * FROM toytypes")->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Edit</h2>
        <?php if(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php elseif(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
    <div class="lg:flex gap-5">
        <form action="../../processors/toys/edit.php" method="POST" class="flex flex-col text-md gap-3 lg:w-1/2" enctype="multipart/form-data">
            <div class="flex flex-col gap-1">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['imageError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['imageError']; ?></p>
                    <?php unset($_SESSION['imageError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($_SESSION['oldName'] ?? $toy['name']) ?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['nameError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['nameError']; ?></p>
                    <?php unset($_SESSION['nameError']); ?>
                <?php endif; ?>
            </div>
            <div class="flex flex-col gap-1">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" value="<?= htmlspecialchars($_SESSION['oldDescription'] ?? $toy['description']) ?>"class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['descriptionError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['descriptionError']; ?></p>
                    <?php unset($_SESSION['descriptionError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex gap-5">
                <div>
                    <label for="min">Minimum Age</label>
                    <input type="number" name="min" id="min" value="<?= htmlspecialchars($_SESSION['oldMin'] ?? $toy['min_age']) ?>" class="p-1 w-1/2 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                    <?php if(isset($_SESSION['minError'])): ?>
                        <p class="text-end text-xs"><?= $_SESSION['minError']; ?></p>
                        <?php unset($_SESSION['minError']); ?>
                    <?php endif; ?>
                </div>
                <div>
                    <label for="max">Maximum Age</label>
                    <input type="number" name="max" id="max" value="<?= htmlspecialchars($_SESSION['oldMax'] ?? $toy['max_age']) ?>" class="p-1 w-1/2 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                    <?php if(isset($_SESSION['maxError'])): ?>
                        <p class="text-end text-xs"><?= $_SESSION['maxError']; ?></p>
                        <?php unset($_SESSION['maxError']); ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="price">Price</label>
                <input type="text" name="price" id="price"  value="<?= htmlspecialchars($_SESSION['oldPrice'] ?? $toy['price']) ?>"class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['priceError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['priceError']; ?></p>
                    <?php unset($_SESSION['priceError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock"  value="<?= htmlspecialchars($_SESSION['oldStock'] ?? $toy['stock']) ?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['stockError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['stockError']; ?></p>
                    <?php unset($_SESSION['stockError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="brand">Brand</label>
                <select name="brand" id="brand" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                    <?php foreach($brands as $brand): ?>
                        <option value="<?= $brand['bid'] ?>" <?= (($_SESSION['oldBrand'] ?? $toy['bid']) == $brand['bid']) ? 'selected' : '' ?>><?= $brand['brand'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if(isset($_SESSION['brandError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['brandError']; ?></p>
                    <?php unset($_SESSION['brandError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="category">Category</label>
                <select name="category" id="category" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                    <?php foreach($categories as $category): ?>
                        <option value="<?= $category['tcid'] ?>" <?= (($_SESSION['oldCategory'] ?? $toy['tcid']) == $category['tcid']) ? 'selected' : '' ?>><?= $category['category'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if(isset($_SESSION['categoryError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['categoryError']; ?></p>
                    <?php unset($_SESSION['categoryError']); ?>
                <?php endif; ?>
            </div>

            <div class="flex flex-col gap-1">
                <label for="type">Type</label>
                <select name="type" id="type" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                    <?php foreach($types as $type): ?>
                        <option value="<?= $type['ttid'] ?>" <?= (($_SESSION['oldType'] ?? $toy['ttid']) == $type['ttid']) ? 'selected' : ''; unset($_SESSION['oldType']) ?>><?= $type['type'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php if(isset($_SESSION['typeError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['typeError']; ?></p>
                    <?php unset($_SESSION['typeError']); ?>
                <?php endif; ?>
            </div>
            <div>
                <button type="submit" class="py-1 px-5 w-fit bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Update</button>
                <a href="../toys.php" class="py-1 px-5 w-fit bg-gray-200 text-xl rounded-lg transition duration-300 hover:bg-gray-300">Cancel</a>
            </div>
        </form>
        <div class="m-10 lg:m-0 lg:w-1/2 justify-items-center text-white">
            <div class="p-5 w-fit flex flex-col gap-2 bg-red-600 rounded-lg shadow-lg">
                <img src="../../storage/images/toys/<?=$toy['imagepath'] ?>" alt="Toy" class="lg:h-96 lg:w-96 border self-center border-white border-4 rounded-lg">
                <h2 class="font-bold text-xl text-center"><?= $toy['name'] ?></h2>
                <p class=""><b>Description:</b><br> <?= $toy['description'] ?></p>
                <div>
                    <p><b>Price:</b> $<?= $toy['price'] ?></p>
                    <p><b>Stock:</b> <?= $toy['stock'] ?></p>
                </div>
                <p><b>Age Range:</b> <?= $toy['min_age']  ?> - <?= $toy['max_age'] ?></p>
                <div>
                    <p><b>Brand:</b> <?= $toy['brand'] ?></p>
                    <p><b>Category:</b> <?= $toy['category'] ?></p>
                    <p><b>Type:</b> <?= $toy['type'] ?></p>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../templates/foot.php'; ?>