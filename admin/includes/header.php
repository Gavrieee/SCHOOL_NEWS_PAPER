<?php require_once 'classloader.php'; ?>

<?php
if (!$userObj->isLoggedIn()) {
    header("Location: login.php");
}

if (!$userObj->isAdmin()) {
    header("Location: ../writer/index.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3BOf..."></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../global.css">
    <script src="../global.js" defer></script>
</head>

<body>