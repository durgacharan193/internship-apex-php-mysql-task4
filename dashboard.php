<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; background: #eef; }
        .container { width: 80%; margin: 50px auto; }
        h2 { color: #333; }
        a.button {
            padding: 10px 15px; background: #28a745; color: white;
            text-decoration: none; border-radius: 4px; margin-right: 10px;
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 20px;
        }
        th, td {
            padding: 12px; border: 1px solid #ccc; text-align: left;
        }
        th { background: #ddd; }
        .actions a {
            padding: 6px 10px; text-decoration: none; color: white;
            border-radius: 4px; margin-right: 5px;
        }
        .edit { background: #007bff; }
        .delete { background: #dc3545; }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?></h2>
    <a class="button" href="create.php">+ New Post</a>
    <a class="button" style="background:#444;" href="logout.php">Logout</a>

    <table>
        <tr>
            <th>ID</th><th>Title</th><th>Content</th><th>Date</th><th>Actions</th>
        </tr>
        <?php foreach ($posts as $post): ?>
        <tr>
            <td><?= $post['id'] ?></td>
            <td><?= htmlspecialchars($post['title']) ?></td>
            <td><?= htmlspecialchars(substr($post['content'], 0, 50)) ?>...</td>
            <td><?= $post['created_at'] ?></td>
            <td class="actions">
                <a class="edit" href="edit.php?id=<?= $post['id'] ?>">Edit</a>
                <a class="delete" href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('Delete this post?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>