<?php require_once '../includes/functions.php'; include '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['part_number'], $_POST['quantity'])) {
    addToCart((int)$_POST['part_number'], (int)$_POST['quantity']);
    echo '<p class="card">Item added to cart.</p>';
}
$parts = getCatalog();
?>
<h2>Browse Parts</h2>
<div class="grid">
<?php foreach ($parts as $part): ?>
<div class="card">
    <img src="<?= htmlspecialchars($part['pictureURL']) ?>" alt="<?= htmlspecialchars($part['description']) ?>">
    <h3><?= htmlspecialchars($part['description']) ?></h3>
    <p>Part #: <?= $part['number'] ?></p>
    <p>Price: $<?= number_format($part['price'], 2) ?></p>
    <p>Weight: <?= number_format($part['weight'], 2) ?> lbs</p>
    <p>Available Qty: <?= $part['quantity_on_hand'] ?></p>
    <form method="post">
        <input type="hidden" name="part_number" value="<?= $part['number'] ?>">
        <input type="number" name="quantity" value="1" min="1">
        <input type="submit" value="Add to Cart">
    </form>
</div>
<?php endforeach; ?>
</div>
<?php include '../includes/footer.php'; ?>
