CREATE DATABASE IF NOT EXISTS tournament_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tournament_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'organizer', 'assistant') DEFAULT 'organizer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    format ENUM('5v5', '7v7', '11v11') NOT NULL,
    type ENUM('league', 'knockout', 'groups_knockout') DEFAULT 'league',
    status ENUM('draft', 'active', 'finished', 'archived') DEFAULT 'draft',
    match_duration INT DEFAULT 10,
    points_win INT DEFAULT 3,
    points_draw INT DEFAULT 1,
    points_loss INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE
);

CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tournament_id INT NOT NULL,
    team1_id INT NOT NULL,
    team2_id INT NOT NULL,
    round_number INT DEFAULT 1,
    match_date DATE DEFAULT NULL,
    match_time TIME DEFAULT NULL,
    score1 INT DEFAULT NULL,
    score2 INT DEFAULT NULL,
    status ENUM('scheduled', 'live', 'finished', 'cancelled') DEFAULT 'scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tournament_id) REFERENCES tournaments(id) ON DELETE CASCADE,
    FOREIGN KEY (team1_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (team2_id) REFERENCES teams(id) ON DELETE CASCADE
);

-- Mot de passe: admin123
INSERT INTO users (name, email, password_hash, role)
VALUES (
    'Admin',
    'admin@tournament.test',
    '$2y$10$Jq6D4Xf0R0a1t4j2W4uH8eYhBv/7a6l0aOPp7Gd8g.j4mJ7qkW8T2',
    'super_admin'
);