<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoParts Online</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
<header>
    <h1>AutoParts Online</h1>
    <nav>
        <a href="../customer/index.php">Catalog</a>
        <a href="../customer/cart.php">Cart</a>
        <a href="../admin/admin.php">Admin</a>
        <a href="../warehouse/warehouse_packing.php">Shipping</a>
        <a href="../warehouse/warehouse_receiving.php">Receiving</a>
    </nav>
</header>
<main>
