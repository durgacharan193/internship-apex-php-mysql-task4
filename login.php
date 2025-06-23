<?php
session_start();
require 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; }
        .container {
            width: 400px; margin: 100px auto; background: white; padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1); border-radius: 8px;
        }
        h2 { text-align: center; color: #333; }
        input[type=text], input[type=password] {
            width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type=submit] {
            background-color: #2196F3; color: white; padding: 10px;
            border: none; border-radius: 4px; width: 100%; cursor: pointer;
        }
        .message { color: red; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" value="Login" />
    </form>
    <p class="message"><?= $message ?></p>
    <p style="text-align:center;"><a href="register.php">Don't have an account? Register</a></p>
</div>
</body>
</html>