<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// handle reorder via AJAX
if (isset($_POST['order'])) {
    foreach ($_POST['order'] as $position => $reqId) {
        $stmt = $mysqli->prepare('UPDATE queue SET position=? WHERE id=?');
        $pos = $position + 1;
        $stmt->bind_param('ii', $pos, $reqId);
        $stmt->execute();
    }
    exit('ok');
}

$result = $mysqli->query("SELECT q.id, s.title, s.youtube_link, u.username FROM queue q JOIN songs s ON q.song_id = s.id JOIN users u ON q.requester_id = u.id ORDER BY q.position ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Karaoke Queue</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($_SESSION['role']); ?></h1>
    <a href="create_song.php">Add Song</a> | <a href="logout.php">Logout</a>
    <h2>Queue</h2>
    <ul id="queue">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li data-id="<?php echo $row['id']; ?>">
                <?php echo htmlspecialchars($row['title']); ?> - <?php echo htmlspecialchars($row['username']); ?>
                [<a href="<?php echo htmlspecialchars($row['youtube_link']); ?>" target="_blank">YouTube</a>]
            </li>
        <?php endwhile; ?>
    </ul>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
