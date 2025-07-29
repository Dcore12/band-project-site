<?php
session_start();
include '../include/db.php';

// Only allow access if user is admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../include/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart Items (Admin)</title>
    <link rel="stylesheet" href="style_php.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Orbitron&family=Staatliches&family=Teko&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: 'Orbitron', sans-serif;
            padding: 2rem;
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
        table {
            width: 100%;
            border-collapse: collapse;
            color: #f26850;
        }
        th, td {
            border: 1px solid #444;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #1c1c1c;
        }
        tr:nth-child(even) {
            background-color: #2a2a2a;
        }
        h1 {
            color: #dc3545;
            margin-bottom: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #121212;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(255,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="admin-container">
  
  </div>
    <div class="container">
        <div class="top-links" style="text-align: right;">
    <a href="../index.php">Home</a>
    <a href="../include/admin.php">Admin</a>
    <a href="../include/logout.php">Logout</a>
    </div>
        <h1>🛒 Cart Items (Admin View)</h1>
        
        <table>
            <tr>
                <th>User</th>
                <th>Product</th>
                <th>Price (€)</th>
                <th>Quantity</th>
                <th>Added At</th>
            </tr>
            <?php
            $query = "SELECT cl.*, u.username 
                      FROM cart_log cl 
                      LEFT JOIN users u ON cl.user_id = u.id 
                      ORDER BY cl.added_at DESC";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['username'] ?? 'Guest') . "</td>
                        <td>" . htmlspecialchars($row['product_name']) . "</td>
                        <td>" . number_format($row['price'], 2) . "</td>
                        <td>" . (int)$row['quantity'] . "</td>
                        <td>" . $row['added_at'] . "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No cart items found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
