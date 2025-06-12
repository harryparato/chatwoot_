<?php
require_once 'includes/db.php';
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = get_db();
    $stmt = $db->prepare('SELECT * FROM users WHERE username=?');
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && (password_verify($_POST['password'], $user['password']) || $user['password'] === $_POST['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
        exit();
    } else {
        $error = 'Credenziali non valide';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<h1>Login</h1>
<form method="post">
    <label>Username <input type="text" name="username" required></label><br>
    <label>Password <input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
</form>
<p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
</body>
</html>
