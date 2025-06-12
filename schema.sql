-- Schema per l'app Karaoke
CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE
);
INSERT INTO roles (name) VALUES ('admin'), ('gestore'), ('cliente'), ('giudice');

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role_id INT NOT NULL,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE songs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  artist VARCHAR(200),
  youtube_link VARCHAR(255),
  category_id INT,
  created_by INT,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (created_by) REFERENCES users(id)
);

CREATE TABLE song_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  song_id INT NOT NULL,
  requested_by INT NOT NULL,
  position INT DEFAULT 0,
  status VARCHAR(20) DEFAULT 'queued',
  FOREIGN KEY (song_id) REFERENCES songs(id),
  FOREIGN KEY (requested_by) REFERENCES users(id)
);

CREATE TABLE public_votes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  request_id INT NOT NULL,
  voter_id INT NOT NULL,
  score INT CHECK (score BETWEEN 1 AND 5),
  FOREIGN KEY (request_id) REFERENCES song_requests(id),
  FOREIGN KEY (voter_id) REFERENCES users(id)
);

CREATE TABLE judge_scores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  request_id INT NOT NULL,
  judge_id INT NOT NULL,
  engagement INT,
  fun INT,
  pitch INT,
  rhythm INT,
  tempo INT,
  comments TEXT,
  FOREIGN KEY (request_id) REFERENCES song_requests(id),
  FOREIGN KEY (judge_id) REFERENCES users(id)
);
