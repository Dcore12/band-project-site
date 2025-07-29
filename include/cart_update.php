<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';

switch ($action) {
    case 'add':
        if ($id) {
            $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        }
        break;

    case 'remove':
        if ($id && isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]--;
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
        break;

    case 'delete':
        if ($id && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        break;

    case 'clear':
        $_SESSION['cart'] = [];
        break;

    case 'count':
        // Apenas conta, sem alterar nada
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Ação inválida.']);
        exit;
}

$cart_count = array_sum($_SESSION['cart']);

echo json_encode([
    'success' => true,
    'cart_count' => $cart_count,
    'cart_items' => $_SESSION['cart'] // opcional: para debug ou listagem
]);
