<?php
require 'config.php';
if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if (isset($_POST['username'], $_POST['password'], $_POST['role'])) {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare('INSERT INTO users (username, password, role) VALUES (?,?,?)');
    $stmt->bind_param('sss', $_POST['username'], $hash, $_POST['role']);
    $stmt->execute();
    $stmt->close();
}

$users = $mysqli->query('SELECT id, username, role FROM users');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>User Management</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="admin">admin</option>
            <option value="manager">gestore canzoni</option>
            <option value="client">cliente</option>
            <option value="judge">giudice</option>
        </select>
        <button type="submit">Add User</button>
    </form>
    <h2>Existing Users</h2>
    <ul>
        <?php while ($u = $users->fetch_assoc()): ?>
            <li><?php echo htmlspecialchars($u['username']).' ('.$u['role'].')'; ?></li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
