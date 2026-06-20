<?php 
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Dashboard";

include('templates/adminHead.php');
include('templates/adminNavbar.php');
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col">
    <h2 class="text-4xl font-bold">Dashboard</h2>
    
    
</main>
<?php include('templates/foot.php'); ?>