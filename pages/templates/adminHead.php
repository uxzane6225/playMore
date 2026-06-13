<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if(isset($_SESSION['title'])): ?>
            <?= $_SESSION['title']; ?> |
        <?php endif; ?>
        playMore.com
    </title>
    <link rel="icon" href="../../resources/images/playMoreLogo.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex">