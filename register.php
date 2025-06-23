<?php
require 'db.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = 'author';

    if (!empty($username) && !empty($password)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hash, $role]);
        header("Location: login.php");
        exit;
    } else {
        $message = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; }
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
            background-color: #4CAF50; color: white; padding: 10px;
            border: none; border-radius: 4px; width: 100%; cursor: pointer;
        }
        .message { color: red; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" value="Register" />
    </form>
    <p class="message"><?= $message ?></p>
    <p style="text-align:center;"><a href="login.php">Already have an account? Login</a></p>
</div>
</body>
</html>