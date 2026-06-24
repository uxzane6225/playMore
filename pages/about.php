<?php
require __DIR__ . '/../processors/auth/auth.php';

$_SESSION['title'] = "About";

include 'templates/head.php';
include 'templates/navbar.php';
?>
<main class="p-10 w-full flex flex-col gap-5">
    <section>
        <h1 class="text-2xl font-bold">What is this?</h1>
        <p>This a project for one my 3rd trimester subject <i>Web System's and Technologies</i>. Serving as a final output.</p>
        <ul class="list-disc">
            <li><strong>School:</strong> Holy Trinity </li>
            <li><strong>Program:</strong> Bachelor of Science in Information Technology</li>
            <li><strong>Year: </strong> 2nd Year (at the time of making the project)</li>
            <li><strong>Trimester: </strong>3rd Trimester (at the time of making the project)</li>
        </ul>
    </section>
    <section>
        <h1 class="text-2xl font-bold">Who made this?</h1>
        <ul class="list-disc">
            <li><strong>Name:</strong> Uriel Laurence M. Mendoza</li>
            <li><strong>Program:</strong> Bachelor of Science in Information Technology</li>
            <li><strong>Year: </strong> 2nd Year (at the time of making the project)</li>
            <li><strong>Trimester: </strong>3rd Trimester (at the time of making the project)</li>
        </ul>
    </section>
     <section>
        <h1 class="text-2xl font-bold">Why this?</h1>
        <p>I chose Toy Store Management System, because: </p>
        <ul class="list-disc">
            <li>Less likely to be chosen</li>
            <li>I'm actually interested of making a management system themed around Toy Stores</li>
            <li>Similarity to my past college project from the previous trimester, which was a Firearms Dealership System.</li>
        </ul>
    </section>
    <section>
        <h1 class="text-2xl font-bold">Requirements</h1>
        <ol class="list-decimal">
            <li>Custom Login Page</li>
            <li>Custom Registration Page</li>
            <li>Custom Dashboard</li>
            <li>Session-Based Authentication</li>
            <li>Role-Based Authorization</li>
            <li>Protected Pages</li>
            <li>Session Timeout</li>
            <li>CRUD Module</li>
            <li>Administrator-Only Delete Functionality</li>
            <li>PDO Database Connectivity</li>
            <li>Secure Password Storage</li>
            <li>Input Validation and Output Escaping</li>
        </ol>
    </section>
</main>
<footer class="p-5 w-full bg-red-600 text-white">
    <p><span class="font-bold">&copy;</span> Uriel Laurence M. Mendoza | 2nd Year - 3rd Trimester | ITWS Finals Project</p>
</footer>
<?php include('templates/foot.php'); ?>