<?php
require_once 'includes/auth.php';
require_login();
$db = get_db();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare('REPLACE INTO public_votes (request_id, voter_id, score) VALUES (?,?,?)');
    $stmt->execute([$_POST['request_id'], $_SESSION['user_id'], $_POST['score']]);
}
$performed = $db->query("SELECT sr.id, s.title FROM song_requests sr JOIN songs s ON sr.song_id=s.id WHERE sr.status='performed'")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Vota</title>
<link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<h1>Votazioni Pubblico</h1>
<?php foreach ($performed as $p): ?>
<form method="post">
    <strong><?php echo htmlspecialchars($p['title']); ?></strong>
    <input type="hidden" name="request_id" value="<?php echo $p['id']; ?>">
    <select name="score">
        <?php for ($i=1;$i<=5;$i++): ?>
        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select>
    <button type="submit">Vota</button>
</form>
<?php endforeach; ?>
<a href="index.php">Home</a>
</body>
</html>
