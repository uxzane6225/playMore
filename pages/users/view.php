<?php 
require __DIR__ . '/../../processors/auth/auth.php';
$_SESSION['title'] = "Create Admin/Staff";

include '../templates/adminHead.php';
include '../templates/adminNavbar.php';

$aid = $_GET['aid'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM accounts a INNER JOIN profiles p ON p.aid = a.aid WHERE a.aid = ?");
$stmt->execute([$aid]);
$account = $stmt->fetch();

//$stmt = $pdo->prepare("SELECT * FROM sales s INNER JOIN sale_details sd ON sd.sid = s.sid WHERE s.cid = ?");
//$stmt->execute([$aid]);
//$purchase = $stmt->fetch();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM sales WHERE cid = ?");
$stmt->execute([$aid]);
$totalPurchase = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(sd.sid) FROM sales s INNER JOIN sale_details sd ON sd.sid = s.sid WHERE s.cid = ?");
$stmt->execute([$aid]);
$totalBought = $stmt->fetchColumn();

if (!$account) {
    $_SESSION['error'] = "Account not found!";
    header("Location: ../categories.php");
    exit;
}

$_SESSION['targetAid'] = $account['aid'];
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col gap-3">
    <header class="mt-5 mx-5 p-5 flex flex-col items-center gap-5 text-white bg-red-600 rounded-xl shadow-lg lg:flex-row lg:items-start">
        <img src="../../storage/images/pfp/<?= isset($account['pfp']) ? $account['pfp'] : "blankPfp.jpg" ?>" alt="Profile Picture" class="w-60 h-60 border border-4 border-white rounded-full">
        <div class="text-center lg:py-5 lg:text-left">
            <h1 class="text-xl font-bold lg:text-3xl"><?= $_SESSION['username']; ?>'s Profile</h1>
            <p><?= isset($account['bio']) ? $account['bio'] : "No description"; ?></p>
            <p><span class="font-bold">Gender: </span><?= isset($account['gender']) ? $account['gender'] : "None"; ?></p>
            <p><span class="font-bold">Birthday: </span><?= isset($account['birthdate']) ? $account['birthdate'] : "None"; ?></p>
            <!-- <p><?= isset($_SESSION['pfp']) ? $_SESSION['pfp'] : "blankPfp.jpg" ?></p> -->
        </div>
    </header>
    <section class="mx-5 p-5 flex flex-col gap-2 bg-gray-200 rounded-xl shadow-lg">
        <h2 class="p-3 text-2xl font-bold ">User Information</h2>
        <div class="lg:pl-5 flex flex-col lg:flex-row gap-10">
            <div class="p-5 bg-red-600 text-white rounded-xl">
                <h3 class="text-xl font-bold">Account Details</h3>
                <div class="pl-3">
                    <p><span class="font-bold">Full Name:</span> <?= $account['fullname'] ?></p>
                    <p><span class="font-bold">Email Address:</span> <?= $account['email'] ?></p>
                    <p><span class="font-bold">Phone #:</span> <?= $account['phone'] ?></p>
                    <p><span class="font-bold">Home Address:</span> <?= $account['address'] ?></p>
                </div>
            </div>
            
            <div class="p-5 bg-green-600 text-white rounded-xl">
                <h3 class="text-xl font-bold">Transaction Details</h3>
                <div class="pl-3">
                    <p><span class="font-bold">Number of purchases:</span> <?= $totalPurchase ?></p>
                    <p><span class="font-bold">Number of products bought:</span> <?= $totalBought ?></p>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include '../templates/foot.php'; ?>