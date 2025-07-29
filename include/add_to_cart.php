<?php
session_start();
header('Content-Type: application/json');

// Configuração de erros
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/cart_errors.log');

try {
    // Verificação de autenticação
    if (!isset($_SESSION['user'])) {
        throw new Exception('User not logged in', 401);
    }

    // Verificação do método HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method', 405);
    }

    // Verificação do ID do produto
    if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
        throw new Exception('Product ID missing', 400);
    }

    include __DIR__ . '/db.php';
    $productId = (int)$_POST['product_id'];

    // Carregar catálogo
    $catalogFile = dirname(__DIR__) . '/catalog.json';
    if (!file_exists($catalogFile)) {
        throw new Exception('Catalog file not found', 500);
    }

    $catalog = json_decode(file_get_contents($catalogFile), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid catalog format', 500);
    }

    // Encontrar produto no catálogo
    $product = null;
    foreach ($catalog['products'] as $item) {
        if ($item['id'] == $productId) {
            $product = $item;
            break;
        }
    }

    if (!$product) {
        throw new Exception('Product not found in catalog', 404);
    }

    // Inicializar carrinho se não existir
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verificar se produto já está no carrinho
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }

    // Adicionar novo item se não encontrado
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1
        ];
    }

    // Calcular quantidade total
    $totalCount = array_sum(array_column($_SESSION['cart'], 'quantity'));

    // Resposta de sucesso
    echo json_encode([
        'success' => true,
        'count' => $totalCount,
        'message' => 'Product added to cart'
    ]);

} catch (Exception $e) {
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'count' => isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0
    ]);
}
?>