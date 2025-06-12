<?php
require_once 'includes/auth.php';
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}
$user = current_user();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Karaoke Queue</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <h1>Benvenuto <?php echo htmlspecialchars($user['username']); ?></h1>
    <nav>
        <a href="queue.php">Coda</a> |
        <a href="songs/add.php">Aggiungi Canzone</a> |
        <a href="vote.php">Vota</a> |
        <?php if ($user['role'] === 'giudice') : ?>
            <a href="judge.php">Giuria</a> |
        <?php endif; ?>
        <?php if ($user['role'] === 'admin') : ?>
            <a href="admin/users.php">Utenti</a> |
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>
</body>
</html>
