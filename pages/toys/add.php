<?php 
require __DIR__ . '/../../processors/auth/auth.php';
$_SESSION['title'] = "Add Toy";

include '../templates/adminHead.php';
include '../templates/adminNavbar.php';

$categories = $pdo->query("SELECT * FROM toycategories")->fetchAll(PDO::FETCH_ASSOC);
$brands = $pdo->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
$types = $pdo->query("SELECT * FROM toytypes")->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <div class="flex gap-5 items-center">
        <h2 class="text-4xl font-bold">Add Toy</h2>
        <?php if(isset($_SESSION['success'])): ?>
            <p class="p-2 text-md text-green-700 bg-green-200 rounded-xl"><?= $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        <?php elseif(isset($_SESSION['error'])): ?>
            <p class="p-2 text-md text-red-700 bg-red-200 rounded-xl"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
    <form action="../../processors/toys/add.php" method="POST" class="flex flex-col text-md gap-3" enctype="multipart/form-data">
        <div class="flex flex-col gap-1">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" value="<?= isset($_SESSION['oldImage']) ? $_SESSION['oldImage'] : ''; unset($_SESSION['oldImage']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['imageError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['imageError']; ?></p>
                <?php unset($_SESSION['imageError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-1">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= isset($_SESSION['oldName']) ? $_SESSION['oldName'] : ''; unset($_SESSION['oldName']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['nameError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['nameError']; ?></p>
                <?php unset($_SESSION['nameError']); ?>
            <?php endif; ?>
        </div>
        <div class="flex flex-col gap-1">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" value="<?= isset($_SESSION['oldDescription']) ? $_SESSION['oldDescription'] : ''; unset($_SESSION['oldDescription']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['descriptionError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['descriptionError']; ?></p>
                <?php unset($_SESSION['descriptionError']); ?>
            <?php endif; ?>
        </div>

         <div class="flex gap-5">
            <div>
                <label for="min">Minimum Age</label>
                <input type="number" name="min" id="min" value="<?= isset($_SESSION['oldMin']) ? $_SESSION['oldMin'] : ''; unset($_SESSION['oldMin']);?>" class="p-1 w-1/2 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['minError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['minError']; ?></p>
                    <?php unset($_SESSION['minError']); ?>
                <?php endif; ?>
            </div>
            <div>
                <label for="max">Maximum Age</label>
                <input type="number" name="max" id="max" value="<?= isset($_SESSION['oldMax']) ? $_SESSION['oldMax'] : ''; unset($_SESSION['oldMax']);?>" class="p-1 w-1/2 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php if(isset($_SESSION['maxError'])): ?>
                    <p class="text-end text-xs"><?= $_SESSION['maxError']; ?></p>
                    <?php unset($_SESSION['maxError']); ?>
                <?php endif; ?>
            </div>
            
        </div>

         <div class="flex flex-col gap-1">
            <label for="price">Price</label>
            <input type="text" name="price" id="price" value="<?= isset($_SESSION['oldPrice']) ? $_SESSION['oldPrice'] : ''; unset($_SESSION['oldPrice']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['priceError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['priceError']; ?></p>
                <?php unset($_SESSION['priceError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-1">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" value="<?= isset($_SESSION['oldStock']) ? $_SESSION['oldStock'] : ''; unset($_SESSION['oldStock']);?>" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
            <?php if(isset($_SESSION['stockError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['stockError']; ?></p>
                <?php unset($_SESSION['stockError']); ?>
            <?php endif; ?>
        </div>

        <div class="flex flex-col gap-1">
            <label for="brand">Brand</label>
            <select name="brand" id="brand" class="p-1 text-black bg-gray-200 rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400">
                <?php foreach($brands as $brand): ?>
                    <option value="<?= $brand['bid'] ?>"><?= $brand['brand'] ?></option>
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
                    <option value="<?= $category['tcid'] ?>"><?= $category['category'] ?></option>
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
                    <option value="<?= $type['ttid'] ?>"><?= $type['type'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php if(isset($_SESSION['typeError'])): ?>
                <p class="text-end text-xs"><?= $_SESSION['typeError']; ?></p>
                <?php unset($_SESSION['typeError']); ?>
            <?php endif; ?>
        </div>
        <div>
            <button class="py-1 px-5 w-fit bg-red-600 text-white text-xl rounded-lg transition duration-300 hover:bg-red-500">Add</button>
            <a href="../toys.php" class="py-1 px-5 w-fit bg-gray-400 text-white text-xl rounded-lg transition duration-300 hover:bg-gray-300">Cancel</a>
        </div>
    </form>
</main>
<?php include '../templates/foot.php'; ?>