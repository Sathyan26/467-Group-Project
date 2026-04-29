<?php require_once '../includes/functions.php'; include '../includes/header.php';
$items = getCartItems();
$totals = calculateTotals($items);
?>
<h2>Your Cart</h2>
<?php if (!$items): ?>
<p class="card">Your cart is empty.</p>
<?php else: ?>
<table>
<tr><th>Part</th><th>Qty</th><th>Unit Price</th><th>Line Total</th></tr>
<?php foreach ($items as $item): ?>
<tr>
    <td><?= htmlspecialchars($item['description']) ?></td>
    <td><?= $item['quantity'] ?></td>
    <td>$<?= number_format($item['price'], 2) ?></td>
    <td>$<?= number_format($item['line_total'], 2) ?></td>
</tr>
<?php endforeach; ?>
</table>
<div class="card">
    <p>Subtotal: $<?= number_format($totals['subtotal'], 2) ?></p>
    <p>Shipping: $<?= number_format($totals['shipping'], 2) ?></p>
    <p>Total: $<?= number_format($totals['total'], 2) ?></p>
    <a href="checkout.php"><button>Proceed to Checkout</button></a>
</div>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>
