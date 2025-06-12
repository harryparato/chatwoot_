<?php
require_once '../includes/auth.php';
require_role('admin');
$db = get_db();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare('INSERT INTO users (username, password, role_id) VALUES (?,?,?)');
    $stmt->execute([
        $_POST['username'],
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        $_POST['role_id']
    ]);
}
$roles = $db->query('SELECT * FROM roles')->fetchAll(PDO::FETCH_ASSOC);
$users = $db->query('SELECT u.id, u.username, r.name as role FROM users u JOIN roles r ON u.role_id=r.id')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Gestione Utenti</title>
<link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
<h1>Utenti</h1>
<form method="post">
    <label>Username <input type="text" name="username" required></label>
    <label>Password <input type="password" name="password" required></label>
    <label>Ruolo
        <select name="role_id">
            <?php foreach ($roles as $role): ?>
            <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit">Crea</button>
</form>
<table>
<tr><th>ID</th><th>Username</th><th>Ruolo</th></tr>
<?php foreach ($users as $u): ?>
<tr><td><?php echo $u['id']; ?></td><td><?php echo htmlspecialchars($u['username']); ?></td><td><?php echo htmlspecialchars($u['role']); ?></td></tr>
<?php endforeach; ?>
</table>
<a href="../index.php">Indietro</a>
</body>
</html>
