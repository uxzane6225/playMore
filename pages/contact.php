<?php
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "Contact";

include 'templates/head.php';
include 'templates/navbar.php';
?>
<main class="m-10 flex flex-col items-center justify-center gap-5 lg:items-start lg:justify-start">
    <header>
        <h1 class="text-2xl lg:text-5xl font-bold lg:hidden">Contact</h1>
    </header>
    <div class="w-full flex items-center justify-evenly">
        <form class="w-full lg:w-1/2 flex flex-col gap-5 rounded-lg lg:bg-red-600 lg:p-5 lg:text-white">
            <div class="flex flex-col gap-2">
                <div class="flex flex-col gap-1">
                    <label for="name" class="pl-2 text-xl font-bold">Full Name</label>
                    <input type="text" id="name" name="name" value="<?= $_SESSION['fullname'] ?>" class="p-2.5 text-black text-lg rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" placeholder="John Doe">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="email" class="pl-2 text-xl font-bold">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= $_SESSION['email'] ?>" class="p-2.5 text-black text-lg rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" placeholder="johndoe@email.com">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="title" class="pl-2 text-xl font-bold">Title</label>
                    <input type="text" id="title" name="title" value="" class="p-2.5 text-black text-lg rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400" placeholder="Hello">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="message" class="pl-2 text-xl font-bold">Message</label>
                    <textarea id="message" name="message" class="p-2.5 text-black text-lg rounded-lg border outline-none lg:border-gray-400 lg:focus:outline-red-400 resize-none"></textarea>
                </div>
            </div>
            
            <button type="submit" id="submit" name="submit" class="p-2 bg-red-600 text-white hover:bg-red-500 rounded-lg transition duration-300 lg:bg-white lg:hover:bg-gray-100 lg:text-black" aria-placeholder="Hello World">Submit</button>
        </form>
        <div class="mx-10 w-1/2 flex flex-col items-center justify-items-center gap-5 text-center hidden lg:block">
            <h2 class="text-3xl font-bold">Contact Us!</h2>
            <p class="mb-10">Give us your feedback! We want to konw more from our customers, because what we value the most is the experience that our customers hold.</p>

            <img src="../resources/images/playMoreLogo.png" alt="Stock Image 1" class="w-96 h-96 rounded-full">
        </div>
    </div>
    
</main>
<footer class="p-5 w-full bg-red-600 text-white">
    <p><span class="font-bold">&copy;</span> Uriel Laurence M. Mendoza | 2nd Year - 3rd Trimester | ITWS Finals Project</p>
</footer>
<?php include('templates/foot.php'); ?>