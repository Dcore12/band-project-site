<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Expiração de sessão após 30 minutos
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
    session_unset();
    session_destroy();
    header("Location: login.php?expired=1");
    exit();
}
$_SESSION['last_activity'] = time();

include __DIR__ . '/db.php';

// Apenas admins podem aceder
if (!isset($_SESSION['user']) || empty($_SESSION['user']['is_admin'])) {
    header("Location: ../index.php");
    exit();
}

// Produtos ativos ou apagados
$showDeleted = isset($_GET['show']) && $_GET['show'] === 'deleted';
$productsQuery = $showDeleted
    ? "SELECT id, name, price, stock, image as image_path FROM products WHERE is_deleted = 1"
    : "SELECT id, name, price, stock, image as image_path FROM products WHERE is_deleted = 0";
$products = $conn->query($productsQuery);
if (!$products) {
    die("Erro ao buscar produtos: " . $conn->error);
}

// Utilizadores
$users = $conn->query("SELECT id, username, email, user_type FROM users");
if (!$users) {
    die("Erro ao buscar utilizadores: " . $conn->error);
}

// Encomendas
$orders = $conn->query("
    SELECT o.id, u.username, o.total_amount, o.status, o.created_at
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");
if (!$orders) {
    die("Erro ao buscar encomendas: " . $conn->error);
}

// BD concertos
$ticketConn = new mysqli("localhost", "root", "root", "concert_tickets_db", 8889);
if ($ticketConn->connect_error) {
    die("Erro ao ligar à base de dados dos concertos: " . $ticketConn->connect_error);
}

$ticketsQuery = "
    SELECT 
        s.id AS sale_id,
        c.name AS customer_name,
        c.email,
        e.name AS event_name,
        t.seat_number,
        t.price,
        s.sale_date
    FROM sales s
    JOIN tickets t ON s.ticket_id = t.id
    JOIN events e ON t.event_id = e.id
    JOIN customers c ON s.customer_id = c.id
    ORDER BY s.sale_date DESC
";
$tickets = $ticketConn->query($ticketsQuery);
if (!$tickets) {
    die("Erro ao buscar bilhetes vendidos: " . $ticketConn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/projecto-banda/CSS/style_php.css">
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Orbitron&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #111;
      color: #fff;
      font-family: 'Orbitron', sans-serif;
      padding: 2rem;
    }
    .admin-container {
      max-width: 1000px;
      margin: auto;
    }
    h1 {
      text-align: center;
      color: #fff;
      margin-bottom: 2rem;
    }
    .section {
      background-color: #1a1a1a;
      border: 1px solid #5c0000;
      padding: 1rem;
      border-radius: 10px;
      margin-bottom: 2rem;
      box-shadow: 0 0 15px #5c0000;
    }
    .section h2 {
      color: #dc3545;
      border-bottom: 1px solid #dc3545;
      padding-bottom: 0.5rem;
      margin-bottom: 1rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1rem;
    }
    table th, table td {
      border: 1px solid #333;
      padding: 8px;
      text-align: center;
    }
    table th {
      background-color: #222;
      color: #a72835;
    }
    .btn.btn-danger {
      color: white;
      padding: 6px 10px;
      font-size: 0.8rem;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      cursor: pointer;
      transition: 0.3s;
      background-color: #a72835;
    }
    .btn:hover {
      background-color: #c04a3f;
      transform: scale(1.05);
      border-radius: 10px 0;
      
    }
    .top-links {
      text-align: right;
      margin-bottom: 1rem;
    }
    .top-links a {
      color: #ff1a1a;
      text-decoration: none;
      font-weight: bold;
    }
    .top-links a:hover {
      text-decoration: underline;
    }
    .product-actions {
      display: flex;
      gap: 0.5rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
<div class="admin-container">
  <div class="top-links">
    <a href="profile.php">Profile</a> |
    <a href="../index.php">Home</a>
  </div>

  <h1>Admin Dashboard</h1>

  <?php if (isset($_GET['deleted_user']) && $_GET['deleted_user'] === 'success'): ?>
    <p style="color: #0f0; text-align: center;">User successfully deleted.</p>
  <?php endif; ?>

  <div class="section">
    <h2>Users</h2>
    <table>
      <tr><th>ID</th><th>Username</th><th>Email</th><th>Type</th><th>Actions</th></tr>
      <?php while ($u = $users->fetch_assoc()): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= htmlspecialchars($u['username']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= $u['user_type'] ?></td>
          <td>
            <a class="btn btn-danger" href="edit_profile.php?id=<?= $u['id'] ?>">Edit</a>
            <a class="btn btn-danger" href="delete_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Confirm delete user?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <div class="section">
    <h2>Products</h2>
    <div class="product-actions">
      <a class="btn btn-danger" href="add_product.php">Add Product</a>
      <a class="btn btn-danger" href="admin.php">Active Products</a>
      <a class="btn btn-danger" href="admin.php?show=deleted">Deleted Products</a>
    </div>
    <table>
      <tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Image</th><th>Actions</th></tr>
      <?php while ($p = $products->fetch_assoc()): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td>€<?= $p['price'] ?></td>
          <td><?= $p['stock'] ?></td>
          <td>
            <?php
            // Extrai apenas o nome do arquivo, removendo qualquer caminho anterior
            $imageName = basename($p['image_path']);
            // Monta o caminho relativo correto
            $imagePath = '../uploads/' . $imageName;
            ?>
            <img src="<?= htmlspecialchars($imagePath) ?>" width="40" alt="Product image">
          </td>
          <td>
            <a class="btn btn-danger" href="edit_product.php?id=<?= $p['id'] ?>">Edit</a>
            <a class="btn btn-danger" href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Confirm delete product?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <div class="section">
    <h2>Orders</h2>
    <table>
      <tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Actions</th></tr>
      <?php while ($o = $orders->fetch_assoc()): ?>
        <tr>
          <td><?= $o['id'] ?></td>
          <td><?= htmlspecialchars($o['username']) ?></td>
          <td>€<?= number_format(floatval($o['total_amount']), 2) ?></td>
          <td><?= htmlspecialchars($o['status']) ?></td>
          <td>
            <a class="btn btn-danger" href="update_order.php?id=<?= $o['id'] ?>">Update</a>
            <a class="btn btn-danger" href="delete_order.php?id=<?= $o['id'] ?>" onclick="return confirm('Confirm delete order?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

  <div class="section">
    <h2>Tickets</h2>
    <div class="product-actions">
      <a class="btn btn-danger" href="ticket_reports.php">Ticket Reports</a>
    </div>
    <table>
      <tr><th>Sale ID</th><th>Customer</th><th>Email</th><th>Event</th><th>Seat</th><th>Price</th><th>Sold At</th></tr>
      <?php while ($t = $tickets->fetch_assoc()): ?>
        <tr>
          <td><?= $t['sale_id'] ?></td>
          <td><?= htmlspecialchars($t['customer_name']) ?></td>
          <td><?= htmlspecialchars($t['email']) ?></td>
          <td><?= htmlspecialchars($t['event_name']) ?></td>
          <td><?= $t['seat_number'] ?: '—' ?></td>
          <td>€<?= number_format($t['price'], 2) ?></td>
          <td><?= date("Y-m-d H:i", strtotime($t['sale_date'])) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>

<?php
$conn->close();
$ticketConn->close();
?>
</body>
</html>
