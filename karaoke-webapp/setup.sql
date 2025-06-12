CREATE DATABASE IF NOT EXISTS karaoke CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE karaoke;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','manager','client','judge') NOT NULL
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
);
INSERT INTO categories (name) VALUES ('Singolo Maschile'),('Singolo Femminile'),('Doppio');

CREATE TABLE songs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  youtube_link VARCHAR(255) NOT NULL,
  category_id INT,
  added_by INT,
  performed TINYINT(1) DEFAULT 0,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (added_by) REFERENCES users(id)
);

CREATE TABLE queue (
  id INT AUTO_INCREMENT PRIMARY KEY,
  song_id INT NOT NULL,
  requester_id INT NOT NULL,
  position INT NOT NULL,
  FOREIGN KEY (song_id) REFERENCES songs(id),
  FOREIGN KEY (requester_id) REFERENCES users(id)
);

CREATE TABLE votes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  song_id INT NOT NULL,
  user_id INT NOT NULL,
  score INT NOT NULL,
  FOREIGN KEY (song_id) REFERENCES songs(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);
