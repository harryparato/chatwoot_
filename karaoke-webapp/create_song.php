<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['title'], $_POST['youtube_link'], $_POST['category_id'])) {
    $stmt = $mysqli->prepare('INSERT INTO songs (title, youtube_link, category_id, added_by) VALUES (?,?,?,?)');
    $stmt->bind_param('ssii', $_POST['title'], $_POST['youtube_link'], $_POST['category_id'], $_SESSION['user_id']);
    $stmt->execute();
    $songId = $stmt->insert_id;
    $stmt->close();

    $stmt = $mysqli->prepare('INSERT INTO queue (song_id, requester_id, position) VALUES (?,?, (SELECT IFNULL(MAX(position),0)+1 FROM queue))');
    $stmt->bind_param('ii', $songId, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
    header('Location: index.php');
    exit;
}

$cats = $mysqli->query('SELECT id, name FROM categories');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Song</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="youtube_search.js"></script>
</head>
<body>
    <h1>Add Song</h1>
    <form method="POST">
        <input type="text" name="title" placeholder="Song Title" required><br>
        <input type="text" name="youtube_link" id="youtube_link" placeholder="YouTube Link" required>
        <button type="button" id="searchBtn">Search YouTube</button><br>
        <select name="category_id" required>
            <?php while ($c = $cats->fetch_assoc()): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
            <?php endwhile; ?>
        </select><br>
        <button type="submit">Add</button>
    </form>
    <div id="results"></div>
</body>
</html>
