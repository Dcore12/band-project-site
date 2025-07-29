<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: ../index.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();

// Processar mudança de senha
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = $_POST['current_password'];
    $nova_senha = $_POST['new_password'];
    $confirmar_senha = $_POST['confirm_password'];

    // Buscar senha atual
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($senha_hash);
    $stmt->fetch();
    $stmt->close();

    // Validar senha atual
    if (!password_verify($senha_atual, $senha_hash)) {
        $mensagem = "❌ Current password is incorrect.";
    } elseif ($nova_senha !== $confirmar_senha) {
        $mensagem = "❌ The new passwords do not match.";
    } elseif (strlen($nova_senha) < 6) {
        $mensagem = "❌ The new password must be at least 6 characters long.";
    } else {
        // Atualizar senha
        $nova_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->bind_param("si", $nova_hash, $user_id);
        $stmt->execute();
        $stmt->close();

        $mensagem = "✅ Password changed successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Pass</title>
    <link rel="stylesheet" href="../CSS/style_php.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Orbitron&family=Staatliches&family=Teko&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Orbitron', sans-serif;
        }
        .container {
            background-color: #111;
            border: 1px solid #5c0000;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px #5c0000;
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin: auto;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 1rem 0;
            border: 2px solid #c04a3f;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 0.3rem 0 1rem;
            border: 1px solid #f26850;
            border-radius: 6px;
            background-color: #222;
            color: #fff;
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

        label {
            font-weight: bold;
            color: #fff;
            display: block;
            text-align: left;
        }

        .mensagem {
            margin: 1rem 0;
            color: #e2bd08;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <div style="text-align: right;">
            <a href="profile.php">Back to Profile</a>
        </div>

        <?php if (!empty($user['profile_pic'])): ?>
            <img src="../<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Foto de Perfil" class="profile-pic">
        <?php endif; ?>

        <h2><?php echo htmlspecialchars($user['username']); ?></h2>

        <?php if (!empty($mensagem)): ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <form method="post" action="change_pass.php">
            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" value="Change Password">
        </form>
    </div>

</body>
</html>
