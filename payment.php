<?php require_once '../includes/functions.php'; include '../includes/header.php';
$items = getCartItems();
$totals = calculateTotals($items);
$data = $_POST;
$result = authorizePayment($data['card_number'] ?? '', $data['exp_date'] ?? '', $totals['total']);
if ($result['approved']) {
    $orderId = createOrder($data, $items, $totals, $result['auth_number'], 'AUTHORIZED');
    $_SESSION['cart'] = [];
    echo '<div class="card"><h2>Order Authorized</h2><p>Order ID: ' . $orderId . '</p><p>Authorization #: ' . htmlspecialchars($result['auth_number']) . '</p><p>A confirmation email would be sent to ' . htmlspecialchars($data['customer_email']) . '.</p></div>';
} else {
    echo '<div class="card"><h2>Payment Declined</h2><p>Please go back and try again.</p></div>';
}
include '../includes/footer.php'; ?>
