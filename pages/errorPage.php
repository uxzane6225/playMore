<?php 
session_start();
$_SESSION['title'] = "Error Page";

include('templates/header.php');

if (empty($_SESSION['error'])) {
    header("Location: welcomePage.php");
    exit;
}
?>

<main class="h-screen flex items-center justify-center bg-red-500">
    <div class="mx-2 p-3 w-fit flex flex-col items-center justify-center gap-2 text-center bg-white rounded-2xl shadow-2xl md:p-4 lg:p-5">
        <h1 class="text-4xl font-bold">Error!</h1> 
        <p class="text-center">It seems like you have encountered an error!</p>
        <?php if(isset($_SESSION['error'])): ?>
            <p class="text-red-500"><?= $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </div>
</main>

<?php include('templates/footer.php') ?>