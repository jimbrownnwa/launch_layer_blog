<?php
require_once __DIR__ . '/config.php';

function getDatabase() {
    $db = new SQLite3(DB_PATH);
    $db->enableExceptions(true);
    return $db;
}

function initializeDatabase() {
    $db = getDatabase();

    // Create posts table
    $db->exec("
        CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            slug TEXT UNIQUE NOT NULL,
            title TEXT NOT NULL,
            meta_description TEXT,
            content TEXT NOT NULL,
            books_html TEXT,
            topic_used TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            published INTEGER DEFAULT 1
        )
    ");

    // Create topics table to track used topics
    $db->exec("
        CREATE TABLE IF NOT EXISTS topics (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            topic TEXT UNIQUE NOT NULL,
            used INTEGER DEFAULT 0,
            used_at DATETIME
        )
    ");

    // Create index for faster lookups
    $db->exec("CREATE INDEX IF NOT EXISTS idx_posts_slug ON posts(slug)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_posts_created ON posts(created_at DESC)");
    $db->exec("CREATE INDEX IF NOT EXISTS idx_topics_used ON topics(used)");

    // Seed topics from config if table is empty
    global $TOPICS;
    $result = $db->querySingle("SELECT COUNT(*) FROM topics");
    if ($result == 0 && !empty($TOPICS)) {
        $stmt = $db->prepare("INSERT OR IGNORE INTO topics (topic) VALUES (:topic)");
        foreach ($TOPICS as $topic) {
            $stmt->bindValue(':topic', $topic, SQLITE3_TEXT);
            $stmt->execute();
            $stmt->reset();
        }
    }

    $db->close();
}

function getNextTopic() {
    $db = getDatabase();
    $result = $db->querySingle("SELECT id, topic FROM topics WHERE used = 0 ORDER BY RANDOM() LIMIT 1", true);
    $db->close();
    return $result;
}

function markTopicUsed($topicId) {
    $db = getDatabase();
    $stmt = $db->prepare("UPDATE topics SET used = 1, used_at = CURRENT_TIMESTAMP WHERE id = :id");
    $stmt->bindValue(':id', $topicId, SQLITE3_INTEGER);
    $stmt->execute();
    $db->close();
}

function savePost($title, $slug, $metaDescription, $content, $booksHtml, $topicUsed) {
    $db = getDatabase();
    $stmt = $db->prepare("
        INSERT INTO posts (title, slug, meta_description, content, books_html, topic_used)
        VALUES (:title, :slug, :meta_desc, :content, :books, :topic)
    ");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
    $stmt->bindValue(':meta_desc', $metaDescription, SQLITE3_TEXT);
    $stmt->bindValue(':content', $content, SQLITE3_TEXT);
    $stmt->bindValue(':books', $booksHtml, SQLITE3_TEXT);
    $stmt->bindValue(':topic', $topicUsed, SQLITE3_TEXT);
    $stmt->execute();
    $id = $db->lastInsertRowID();
    $db->close();
    return $id;
}

function getRecentPosts($limit = 10, $offset = 0) {
    $db = getDatabase();
    $stmt = $db->prepare("
        SELECT id, slug, title, meta_description, created_at
        FROM posts
        WHERE published = 1
        ORDER BY created_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
    $stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $posts = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $posts[] = $row;
    }
    $db->close();
    return $posts;
}

function getPostBySlug($slug) {
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM posts WHERE slug = :slug AND published = 1");
    $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
    $result = $stmt->execute();
    $post = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();
    return $post;
}

function getTotalPosts() {
    $db = getDatabase();
    $count = $db->querySingle("SELECT COUNT(*) FROM posts WHERE published = 1");
    $db->close();
    return $count;
}

function canGeneratePost() {
    $db = getDatabase();
    $lastPost = $db->querySingle("SELECT created_at FROM posts ORDER BY created_at DESC LIMIT 1");
    $db->close();

    if (!$lastPost) {
        return true;
    }

    $lastTime = strtotime($lastPost);
    $now = time();

    if (TESTING_MODE) {
        // 5 minute interval for testing
        return ($now - $lastTime) >= 300;
    } else {
        // 24 hour interval for production
        return ($now - $lastTime) >= 86400;
    }
}

// Initialize database on first load
initializeDatabase();
