<?php require_once '../includes/functions.php'; include '../includes/header.php'; $pdo = getConnection();
if (isset($_GET['ship'])) {
    $stmt = $pdo->prepare("UPDATE orders SET status='SHIPPED', shipped_date=NOW() WHERE order_id=?");
    $stmt->execute([$_GET['ship']]);
    echo '<p class="card">Order marked as shipped. Shipping confirmation email would be sent.</p>';
}
$orders = $pdo->query("SELECT * FROM orders WHERE status='AUTHORIZED' OR status='PACKED' ORDER BY order_date")->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Warehouse Packing / Shipping</h2>
<table><tr><th>Order ID</th><th>Customer</th><th>Status</th><th>Total</th><th>Action</th></tr>
<?php foreach ($orders as $order): ?>
<tr>
<td><?= $order['order_id'] ?></td>
<td><?= htmlspecialchars($order['customer_name']) ?></td>
<td><?= $order['status'] ?></td>
<td>$<?= number_format($order['total_cost'],2) ?></td>
<td><a href="?ship=<?= $order['order_id'] ?>"><button>Mark Shipped</button></a></td>
</tr>
<?php endforeach; ?>
</table>
<?php include '../includes/footer.php'; ?>
