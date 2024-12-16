CREATE DATABASE BlogPress;
USE BlogPress;
-- @block

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('author', 'visitor') DEFAULT 'visitor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- @block
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    views INT DEFAULT 0,
    likes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- @block
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- @block
CREATE TABLE IF NOT EXISTS likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- @block
CREATE TABLE IF NOT EXISTS views (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    user_ip VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
);
-- @block
INSERT INTO users (username, email, password, role) VALUES
('author1', 'author1@example.com', 'hashed_password_1', 'author'),
('author2', 'author2@example.com', 'hashed_password_2', 'author');

INSERT INTO users (username, email, password, role) VALUES
('visitor1', 'visitor1@example.com', 'hashed_password_visitor1', 'visitor'),
('visitor2', 'visitor2@example.com', 'hashed_password_visitor2', 'visitor');

INSERT INTO articles (title, content, user_id) VALUES
('First Article by Author 1', 'This is a short article for testing. It is just a placeholder content.', 1),
('First Article by Author 2', 'This is another short article for testing. It serves as a sample article content.', 2);

-- @block
SELECT * FROM articles;


