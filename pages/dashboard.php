<?php 
session_start();
require('../config/database.php');

$_SESSION['title'] = "Welcome";

include('templates/adminHead.php');
include('templates/adminNavbar.php');
?>
<main class="p-5 lg:col-span-4 h-full w-full flex flex-col">
    <h2 class="text-4xl font-bold">Dashboard</h2>
    
    
</main>
<?php include('templates/foot.php'); ?>