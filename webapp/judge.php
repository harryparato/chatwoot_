<?php
require_once 'includes/auth.php';
require_role('giudice');
$db = get_db();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare('REPLACE INTO judge_scores (request_id, judge_id, engagement, fun, pitch, rhythm, tempo, comments) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([
        $_POST['request_id'],
        $_SESSION['user_id'],
        $_POST['engagement'],
        $_POST['fun'],
        $_POST['pitch'],
        $_POST['rhythm'],
        $_POST['tempo'],
        $_POST['comments']
    ]);
}
$performed = $db->query("SELECT sr.id, s.title FROM song_requests sr JOIN songs s ON sr.song_id=s.id WHERE sr.status='performed'")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Giuria</title>
<link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<h1>Voti Giuria</h1>
<?php foreach ($performed as $p): ?>
<form method="post">
    <h2><?php echo htmlspecialchars($p['title']); ?></h2>
    <input type="hidden" name="request_id" value="<?php echo $p['id']; ?>">
    <label Coinvolgimento> <input type="number" name="engagement" min="1" max="10" required></label>
    <label Divertimento> <input type="number" name="fun" min="1" max="10" required></label>
    <label Tonalità> <input type="number" name="pitch" min="1" max="10" required></label>
    <label Ritmo> <input type="number" name="rhythm" min="1" max="10" required></label>
    <label Tempo> <input type="number" name="tempo" min="1" max="10" required></label>
    <br>
    <textarea name="comments" placeholder="Commenti"></textarea><br>
    <button type="submit">Salva</button>
</form>
<?php endforeach; ?>
<a href="index.php">Home</a>
</body>
</html>
