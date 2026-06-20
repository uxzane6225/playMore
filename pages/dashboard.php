<?php 
require __DIR__ . '/../processors/auth/auth.php';
$_SESSION['title'] = "Dashboard";

include('templates/adminHead.php');
include('templates/adminNavbar.php');

$totalUsers = $pdo->query('SELECT COUNT(*) FROM accounts')->fetchColumn();
$totalAdmin = $pdo->query('SELECT COUNT(*) FROM accounts WHERE role = "admin"')->fetchColumn();
$totalStaff = $pdo->query('SELECT COUNT(*) FROM accounts WHERE role = "staff"')->fetchColumn();
$totalCustomer = $pdo->query('SELECT COUNT(*) FROM accounts WHERE role = "user"')->fetchColumn();

$totalToys = $pdo->query('SELECT COUNT(*) FROM toys')->fetchColumn();
$totaBrands = $pdo->query('SELECT COUNT(*) FROM brands')->fetchColumn();
$totalCategories = $pdo->query('SELECT COUNT(*) FROM toycategories')->fetchColumn();
$totalTypes = $pdo->query('SELECT COUNT(*) FROM toytypes')->fetchColumn();
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-5">
    <h2 class="text-4xl font-bold">Dashboard</h2>
    <div class="p-5 h-full w-full grid grid-cols-3 justify-items-center items-center gap-5 bg-gray-200">
        <div class="p-2 lg:px-10 h-fit w-fit text-white text-center bg-red-600 rounded-xl">
            <h3 class="text-2xl font-bold"><?= $totalToys ?></h3>
            <p>Total Number of Toys</p>
        </div>

        <div class="p-2 lg:px-10 h-fit w-fit text-white text-center bg-red-600 rounded-xl">
            <h3 class="text-2xl font-bold"><?= $totalUsers ?></h3>
            <p>Total Number of Users</p>
        </div>

        <div class="p-2 lg:px-10 h-fit w-fit text-white text-center bg-red-600 rounded-xl">
            <h3 class="text-2xl font-bold"><?= $totaBrands ?></h3>
            <p>Number of Brands</p>
        </div>

        <div class="p-2 lg:px-10 h-fit w-fit text-white text-center bg-red-600 rounded-xl">
            <h3 class="text-2xl font-bold"><?= $totalCategories ?></h3>
            <p>Number of Categories</p>
        </div>

        <div class="p-2 lg:px-10 h-fit w-fit text-white text-center bg-red-600 rounded-xl">
            <h3 class="text-2xl font-bold"><?= $totalCategories ?></h3>
            <p>Number of Types</p>
        </div>

        <div class="p-2 lg:px-10 h-fit w-fit text-white text-center bg-red-600 rounded-xl">
            <h3 class="text-2xl font-bold"><?= $totalAdmin ?></h3>
            <p>Number of Admins</p>
        </div>

        <div class="p-2 lg:px-10 h-fit w-fit text-white text-center bg-red-600 rounded-xl">
            <h3 class="text-2xl font-bold"><?= $totalStaff ?></h3>
            <p>Number of Staff</p>
        </div>

        <div class="p-2 lg:px-10 h-fit w-fit text-white text-center bg-red-600 rounded-xl">
            <h3 class="text-2xl font-bold"><?= $totalCustomer ?></h3>
            <p>Number of Customers</p>
        </div>
    </div>
</main>
<?php include('templates/foot.php'); ?>