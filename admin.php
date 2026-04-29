<?php require_once '../includes/functions.php'; include '../includes/header.php'; $pdo = getConnection();
$orders = $pdo->query('SELECT * FROM orders ORDER BY order_date DESC')->fetchAll(PDO::FETCH_ASSOC);
$rules = $pdo->query('SELECT * FROM shipping_rules ORDER BY min_weight')->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Administrator Dashboard</h2>
<div class="card"><h3>Shipping Rules</h3>
<table><tr><th>Min Weight</th><th>Max Weight</th><th>Charge</th></tr>
<?php foreach ($rules as $rule): ?><tr><td><?= $rule['min_weight'] ?></td><td><?= $rule['max_weight'] ?></td><td>$<?= number_format($rule['charge'],2) ?></td></tr><?php endforeach; ?>
</table></div>
<div class="card"><h3>Orders</h3>
<table><tr><th>Order ID</th><th>Customer</th><th>Status</th><th>Date</th><th>Total</th></tr>
<?php foreach ($orders as $order): ?><tr><td><?= $order['order_id'] ?></td><td><?= htmlspecialchars($order['customer_name']) ?></td><td><?= $order['status'] ?></td><td><?= $order['order_date'] ?></td><td>$<?= number_format($order['total_cost'],2) ?></td></tr><?php endforeach; ?>
</table></div>
<?php include '../includes/footer.php'; ?>
