<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['song_id'], $_POST['score'])) {
    $stmt = $mysqli->prepare('REPLACE INTO votes (song_id, user_id, score) VALUES (?,?,?)');
    $stmt->bind_param('iii', $_POST['song_id'], $_SESSION['user_id'], $_POST['score']);
    $stmt->execute();
    $stmt->close();
}

$songs = $mysqli->query('SELECT id, title FROM songs WHERE performed = 1');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Vote</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Vote</h1>
    <form method="POST">
        <select name="song_id">
            <?php while ($s = $songs->fetch_assoc()): ?>
                <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['title']); ?></option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="score" min="1" max="5" required>
        <button type="submit">Submit Vote</button>
    </form>
</body>
</html>
