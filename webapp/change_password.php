<?php
require_once 'includes/auth.php';
require_login();
$db = get_db();
$user = current_user();
$error = '';
$ok = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['new_password'] !== $_POST['confirm_password']) {
        $error = 'Le password non coincidono';
    } else {
        $stmt = $db->prepare('UPDATE users SET password=? WHERE id=?');
        $stmt->execute([
            password_hash($_POST['new_password'], PASSWORD_DEFAULT),
            $user['id']
        ]);
        $ok = 'Password aggiornata';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Cambia Password</title>
<link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<h1>Cambia Password</h1>
<?php if ($error): ?>
<p class="error"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
<?php if ($ok): ?>
<p class="success"><?php echo htmlspecialchars($ok); ?></p>
<?php endif; ?>
<form method="post">
    <label>Nuova Password <input type="password" name="new_password" required></label><br>
    <label>Conferma Password <input type="password" name="confirm_password" required></label><br>
    <button type="submit">Aggiorna</button>
</form>
<a href="index.php">Home</a>
</body>
</html>
