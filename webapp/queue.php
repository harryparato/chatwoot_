<?php
require_once 'includes/auth.php';
require_login();
$db = get_db();
if (isset($_POST['move'])) {
    $id = (int)$_POST['id'];
    $direction = $_POST['move'];
    $stmt = $db->prepare('SELECT position FROM song_requests WHERE id=?');
    $stmt->execute([$id]);
    $current = $stmt->fetchColumn();
    if ($direction === 'up') {
        $stmt = $db->prepare('SELECT id, position FROM song_requests WHERE position < ? ORDER BY position DESC LIMIT 1');
    } else {
        $stmt = $db->prepare('SELECT id, position FROM song_requests WHERE position > ? ORDER BY position ASC LIMIT 1');
    }
    $stmt->execute([$current]);
    $swap = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($swap) {
        $db->beginTransaction();
        $db->prepare('UPDATE song_requests SET position=? WHERE id=?')->execute([$swap['position'], $id]);
        $db->prepare('UPDATE song_requests SET position=? WHERE id=?')->execute([$current, $swap['id']]);
        $db->commit();
    }
}
$queue = $db->query('SELECT sr.id, sr.position, s.title, u.username FROM song_requests sr JOIN songs s ON sr.song_id=s.id JOIN users u ON sr.requested_by=u.id ORDER BY sr.position')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Coda</title>
<link rel="stylesheet" href="assets/styles.css">
</head>
<body>
<h1>Coda delle Canzoni</h1>
<table>
<tr><th>Posizione</th><th>Titolo</th><th>Richiedente</th><th>Azioni</th></tr>
<?php foreach ($queue as $q): ?>
<tr>
    <td><?php echo $q['position']; ?></td>
    <td><?php echo htmlspecialchars($q['title']); ?></td>
    <td><?php echo htmlspecialchars($q['username']); ?></td>
    <td>
        <form method="post" style="display:inline">
            <input type="hidden" name="id" value="<?php echo $q['id']; ?>">
            <button name="move" value="up">Su</button>
            <button name="move" value="down">Giù</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>
<a href="index.php">Home</a>
</body>
</html>
