<?php require_once '../includes/functions.php'; include '../includes/header.php';
$items = getCartItems();
$totals = calculateTotals($items);
?>
<h2>Checkout</h2>
<form method="post" action="payment.php" class="card">
    <input name="customer_name" placeholder="Full Name" required>
    <input name="customer_email" type="email" placeholder="Email" required>
    <input name="address_line1" placeholder="Address Line 1" required>
    <input name="address_line2" placeholder="Address Line 2">
    <input name="city" placeholder="City" required>
    <input name="state" placeholder="State" required>
    <input name="zip_code" placeholder="Zip Code" required>
    <input name="card_number" placeholder="Credit Card Number" required>
    <input name="exp_date" placeholder="MM/YY" required>
    <p>Total Amount: $<?= number_format($totals['total'], 2) ?></p>
    <input type="submit" value="Submit Order">
</form>
<?php include '../includes/footer.php'; ?>
