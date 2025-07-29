<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../include/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $price = floatval($_POST["price"]);
    $stock = intval($_POST["stock"]);
    $imagePath = null;

    // Check if an image was uploaded
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../uploads/";
        $extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $newFileName = uniqid("prod_") . "." . strtolower($extension);
        $targetFile = $targetDir . $newFileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (in_array(strtolower($extension), $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $imagePath = $targetFile;
            } else {
                echo "Failed to upload the image.";
                exit();
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, WEBP and GIF are allowed.";
            exit();
        }
    }

    // Insert product into database
    $stmt = $conn->prepare("INSERT INTO products (name, price, stock, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $name, $price, $stock, $imagePath);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error adding product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
    <link rel="stylesheet" href="CSS/style_php.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Orbitron&family=Staatliches&family=Teko&display=swap"
      rel="stylesheet"
    />
  <style>
    body {
            background-color: #111;
            color: #fff;
            font-family: 'Orbitron', sans-serif;
            padding: 2rem;
        }
        .btn.btn-danger {
            background-color: #c04a3f;
            font-family: 'Orbitron', sans-serif;
            font-weight:bold;
            color: white;
            text-decoration: none;
            padding: 6px 10px;
            font-size: 0.8rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #c04a3f;
            transform: scale(1.05);
            border-radius: 10px 0;
            text-decoration: none;
        }
        input[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 0.7rem;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 8px 0 8px 0;
            cursor: pointer;
            width: 100%;
            transition: 0.4s;
            box-shadow: 0 0 10px #dc3545, inset 0 0 5px #000;
        }

        input[type="submit"]:hover {
            background-color: #a72835;
            box-shadow: 0 0 20px #dc3545, inset 0 0 10px #000;
            transform: scale(1.05);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add New Product</h2>
        <form method="post" enctype="multipart/form-data">
            <label>Product Name:</label>
            <input type="text" name="name" required><br>

            <label>Price (€):</label>
            <input type="number" step="0.01" name="price" required><br>

            <label>Stock:</label>
            <input type="number" name="stock" value="0" required><br>

            <label>Upload Image:</label>
            <input type="file" name="image" accept="image/*"><br><br>

            <button type="submit" class="btn btn-danger">Add Product</button>
            <a href="../include/admin.php" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</body>
</html>
