<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../include/login.php');
    exit;
}


// Processar remoção de item
if (isset($_POST['remove_item'])) {
    $productId = $_POST['product_id'];
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
    header('Location: ../include/cart_items.php');
    exit;
}

// Processar atualização de quantidade
if (isset($_POST['update_quantity'])) {
    $productId = $_POST['product_id'];
    $newQuantity = (int)$_POST['quantity'];
    
    if ($newQuantity > 0 && isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
    } elseif ($newQuantity <= 0) {
        unset($_SESSION['cart'][$productId]);
    }
    
    header('Location: ../include/cart_items.php');
    exit;
}

$cartItems = $_SESSION['cart'] ?? [];
$total = 0;

foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Orbitron&family=Staatliches&family=Teko&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Orbitron', sans-serif;
        }
        .cart-img { max-width: 100px; height: auto; }
        .btn.btn-danger {
            border-radius: 10px 0;
        }
        .btn.btn-danger:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(220, 53, 69, 0.8);
        }
        .quantity-form {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body class="bg-dark text-light">
    <div class="container py-5">
        <h1 class="mb-4">My Shopping Cart</h1>
            <div class="container py-5">
                <p>Logged in as: <?= htmlspecialchars($_SESSION['user']['full_name'] ?: $_SESSION['user']['username']) ?></p>
            </div>
        <?php if (empty($cartItems)): ?>
            <div class="alert alert-info">Your cart is empty</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $id => $item): 
                            $itemTotal = $item['price'] * $item['quantity'];
                        ?>
                            <tr>
                                <td>
                                    <img src="../<?= htmlspecialchars($item['image']) ?>" class="cart-img me-3">
                                    <?= htmlspecialchars($item['name']) ?>
                                </td>
                                <td>€<?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <form method="post" class="quantity-form">
                                        <input type="hidden" name="product_id" value="<?= $id ?>">
                                        <input type="number" name="quantity" min="1" value="<?= $item['quantity'] ?>" 
                                               class="form-control" style="width: 70px;">
                                        <button type="submit" name="update_quantity" class="btn btn-sm btn-outline-light">Update</button>
                                    </form>
                                </td>
                                <td>€<?= number_format($itemTotal, 2) ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="product_id" value="<?= $id ?>">
                                        <button type="submit" name="remove_item" class="btn btn-danger btn-sm">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th colspan="2">€<?= number_format($total, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="../index.php#merch" class="btn btn-danger">Continue Shopping</a>
                <a href="../include/checkout.php" class="btn btn-danger">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>