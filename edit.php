<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo "Post not found.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->execute([$title, $content, $id]);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
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
            background: #007bff; color: white; padding: 10px;
            border: none; width: 100%; border-radius: 4px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Post</h2>
    <form method="POST">
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required />
        <textarea name="content" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
        <button type="submit">Update Post</button>
    </form>
</div>
</body>
</html>