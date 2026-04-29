<?php require_once '../includes/functions.php'; include '../includes/header.php'; $pdo = getConnection();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $part = (int)$_POST['part_number'];
    $qty = (int)$_POST['quantity_received'];
    $pdo->prepare('INSERT INTO inventory (part_number, quantity_on_hand) VALUES (?, ?) ON DUPLICATE KEY UPDATE quantity_on_hand = quantity_on_hand + VALUES(quantity_on_hand)')->execute([$part, $qty]);
    $pdo->prepare('INSERT INTO inventory_receipts (part_number, quantity_received, notes) VALUES (?, ?, ?)')->execute([$part, $qty, $_POST['notes'] ?? null]);
    echo '<p class="card">Inventory updated successfully.</p>';
}
$catalog = getCatalog();
?>
<h2>Warehouse Receiving</h2>
<form method="post" class="card">
    <label>Part Number</label>
    <select name="part_number">
        <?php foreach ($catalog as $part): ?>
        <option value="<?= $part['number'] ?>"><?= $part['number'] ?> - <?= htmlspecialchars($part['description']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Quantity Received</label>
    <input type="number" name="quantity_received" min="1" required>
    <label>Notes</label>
    <input name="notes">
    <input type="submit" value="Update Inventory">
</form>
<?php include '../includes/footer.php'; ?>
