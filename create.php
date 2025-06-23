<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title && $content) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <style>
        body { font-family: Arial; background: #f8f9fa; }
        .container {
            width: 500px; margin: 100px auto; background: white; padding: 30px;
            border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; }
        input, textarea {
            width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background: #28a745; color: white; padding: 10px;
            border: none; width: 100%; border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Create New Post</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Post Title" required />
        <textarea name="content" rows="6" placeholder="Post Content" required></textarea>
        <button type="submit">Save Post</button>
    </form>
</div>
</body>
</html>