<?php
require_once __DIR__.'/db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function is_logged_in() {
    return isset($_SESSION['user_id']);
}
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}
function current_user() {
    if (is_logged_in()) {
        $db = get_db();
        $stmt = $db->prepare('SELECT u.*, r.name AS role FROM users u JOIN roles r ON u.role_id=r.id WHERE u.id=?');
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}
function require_role($role) {
    $user = current_user();
    if (!$user || $user['role'] !== $role) {
        header('HTTP/1.1 403 Forbidden');
        exit('Accesso negato');
    }
}
?>
