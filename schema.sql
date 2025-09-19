-- Database: school_news_paper

-- Articles
CREATE TABLE articles (
  article_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  photo_url VARCHAR(500),
  author_id INT NOT NULL,
  is_active TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (author_id) REFERENCES school_publication_users(user_id) ON DELETE CASCADE
);

-- Edit Requests
CREATE TABLE edit_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  article_id INT NOT NULL,
  requester_id INT NOT NULL,
  owner_id INT NOT NULL,
  status ENUM('pending','accepted','rejected') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (article_id) REFERENCES articles(article_id) ON DELETE CASCADE,
  FOREIGN KEY (requester_id) REFERENCES school_publication_users(user_id) ON DELETE CASCADE,
  FOREIGN KEY (owner_id) REFERENCES school_publication_users(user_id) ON DELETE CASCADE
);

-- Notifications
CREATE TABLE notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  message TEXT NOT NULL,
  is_read TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES school_publication_users(user_id) ON DELETE CASCADE
);

-- Users
CREATE TABLE school_publication_users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  is_admin TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Shared Articles
CREATE TABLE shared_articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  article_id INT NOT NULL,
  user_id INT NOT NULL,
  FOREIGN KEY (article_id) REFERENCES articles(article_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES school_publication_users(user_id) ON DELETE CASCADE
);
