<?php
require_once __DIR__ . '/../config/db_connect.php';
if (session_status() === PHP_SESSION_NONE) session_start();

function getLegacyParts() {
    return [
        ['number'=>1001,'description'=>'Brake Pad Set','price'=>49.99,'weight'=>3.20,'pictureURL'=>'https://via.placeholder.com/120?text=Brake+Pad'],
        ['number'=>1002,'description'=>'Oil Filter','price'=>12.49,'weight'=>0.70,'pictureURL'=>'https://via.placeholder.com/120?text=Oil+Filter'],
        ['number'=>1003,'description'=>'Spark Plug','price'=>8.99,'weight'=>0.20,'pictureURL'=>'https://via.placeholder.com/120?text=Spark+Plug'],
        ['number'=>1004,'description'=>'Air Filter','price'=>19.99,'weight'=>1.00,'pictureURL'=>'https://via.placeholder.com/120?text=Air+Filter']
    ];
}

function getInventoryMap() {
    $pdo = getConnection();
    $stmt = $pdo->query('SELECT part_number, quantity_on_hand FROM inventory');
    $map = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $map[$row['part_number']] = (int)$row['quantity_on_hand'];
    }
    return $map;
}

function getCatalog() {
    $parts = getLegacyParts();
    $inventory = getInventoryMap();
    foreach ($parts as &$part) {
        $part['quantity_on_hand'] = $inventory[$part['number']] ?? 0;
    }
    return $parts;
}

function addToCart($partNumber, $qty) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    $_SESSION['cart'][$partNumber] = ($_SESSION['cart'][$partNumber] ?? 0) + $qty;
}

function getCartItems() {
    $catalog = getCatalog();
    $cart = $_SESSION['cart'] ?? [];
    $items = [];
    foreach ($catalog as $part) {
        if (isset($cart[$part['number']])) {
            $part['quantity'] = $cart[$part['number']];
            $part['line_total'] = $part['quantity'] * $part['price'];
            $items[] = $part;
        }
    }
    return $items;
}

function calculateTotals($items) {
    $subtotal = 0; $weight = 0;
    foreach ($items as $item) {
        $subtotal += $item['line_total'];
        $weight += $item['weight'] * $item['quantity'];
    }
    $shipping = getShippingCharge($weight);
    return ['subtotal'=>$subtotal,'weight'=>$weight,'shipping'=>$shipping,'total'=>$subtotal + $shipping];
}

function getShippingCharge($weight) {
    $pdo = getConnection();
    $stmt = $pdo->prepare('SELECT charge FROM shipping_rules WHERE active = 1 AND ? BETWEEN min_weight AND max_weight LIMIT 1');
    $stmt->execute([$weight]);
    $charge = $stmt->fetchColumn();
    return $charge !== false ? (float)$charge : 0.00;
}

function authorizePayment($cardNumber, $expDate, $amount) {
    if (strlen(preg_replace('/\D/', '', $cardNumber)) < 12) {
        return ['approved'=>false, 'auth_number'=>null];
    }
    return ['approved'=>true, 'auth_number'=>'AUTH' . rand(100000, 999999)];
}

function createOrder($data, $items, $totals, $authNumber = null, $status = 'PENDING') {
    $pdo = getConnection();
    $stmt = $pdo->prepare('INSERT INTO orders (customer_name, customer_email, address_line1, address_line2, city, state, zip_code, status, subtotal, shipping_cost, total_cost, total_weight, auth_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([
        $data['customer_name'], $data['customer_email'], $data['address_line1'], $data['address_line2'] ?? null,
        $data['city'], $data['state'], $data['zip_code'], $status,
        $totals['subtotal'], $totals['shipping'], $totals['total'], $totals['weight'], $authNumber
    ]);
    $orderId = $pdo->lastInsertId();

    $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, part_number, quantity, unit_price, unit_weight, line_total) VALUES (?, ?, ?, ?, ?, ?)');
    foreach ($items as $item) {
        $itemStmt->execute([$orderId, $item['number'], $item['quantity'], $item['price'], $item['weight'], $item['line_total']]);
    }
    return $orderId;
}
?>
