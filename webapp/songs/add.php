<?php
require_once '../includes/auth.php';
require_login();
$db = get_db();
$categories = $db->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare('INSERT INTO songs (title, artist, youtube_link, category_id, created_by) VALUES (?,?,?,?,?)');
    $stmt->execute([
        $_POST['title'],
        $_POST['artist'],
        $_POST['youtube_link'],
        $_POST['category_id'],
        $_SESSION['user_id']
    ]);
    $song_id = $db->lastInsertId();
    $stmt = $db->prepare('INSERT INTO song_requests (song_id, requested_by, position) VALUES (?,?, (SELECT COALESCE(MAX(position),0)+1 FROM song_requests))');
    $stmt->execute([$song_id, $_SESSION['user_id']]);
    header('Location: ../queue.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Aggiungi Canzone</title>
<link rel="stylesheet" href="../assets/styles.css">
<script>
function searchYoutube() {
    var q = document.getElementById('search').value;
    window.open('https://www.youtube.com/results?search_query=' + encodeURIComponent(q), '_blank');
}
</script>
</head>
<body>
<h1>Nuova Canzone</h1>
<form method="post">
    <label>Titolo <input type="text" name="title" required></label><br>
    <label>Artista <input type="text" name="artist"></label><br>
    <label>Categoria
        <select name="category_id">
            <?php foreach ($categories as $c): ?>
            <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Link YouTube <input type="text" name="youtube_link"></label>
    <input type="text" id="search" placeholder="Cerca su YouTube">
    <button type="button" onclick="searchYoutube()">Cerca</button><br>
    <button type="submit">Aggiungi</button>
</form>
<a href="../index.php">Indietro</a>
</body>
</html>
