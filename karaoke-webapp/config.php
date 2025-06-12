<?php
// Basic database connection using MySQLi
$host = 'localhost';
$user = 'karaoke_user';
$password = 'karaoke_pass';
$database = 'karaoke';

$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_errno) {
    die('Failed to connect to MySQL: ' . $mysqli->connect_error);
}

session_start();
?>
