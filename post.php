<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

$slug = $_GET['slug'] ?? '';
$post = getPostBySlug($slug);

if (!$post) {
    http_response_code(404);
    echo '<!DOCTYPE html><html><head><title>Not Found</title></head><body><h1>Post not found</h1><p><a href="index.php">Return to homepage</a></p></body></html>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - <?= htmlspecialchars(BLOG_TITLE) ?></title>
    <meta name="description" content="<?= htmlspecialchars($post['meta_description']) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <h1><a href="index.php"><?= htmlspecialchars(BLOG_TITLE) ?></a></h1>
                <nav class="site-nav">
                    <a href="https://launchlayerlabs.com/">Home</a>
                    <a href="index.php#posts">Articles</a>
                    <a href="index.php#about">About</a>
                    <a href="#subscribe" class="btn-primary">Get Updates</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="post-page-content">
        <div class="container-narrow">
            <article class="post-full">
                <header class="post-header">
                    <h1><?= htmlspecialchars($post['title']) ?></h1>
                    <time datetime="<?= $post['created_at'] ?>"><?= date('F j, Y', strtotime($post['created_at'])) ?></time>
                </header>

                <div class="post-content">
                    <?= $post['content'] ?>
                </div>

                <?= $post['books_html'] ?>

                <footer class="post-footer">
                    <a href="index.php" class="back-link">&larr; Back to all posts</a>
                </footer>
            </article>
        </div>
    </main>

    <section class="cta-section" id="subscribe">
        <div class="container">
            <h2>Ready to level up your business?</h2>
            <p>Get the latest articles and frameworks delivered to your inbox.</p>
            <a href="mailto:subscribe@launchlayerblog.com" class="btn-primary">Get Updates</a>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <div class="footer-brand">
                <h3><?= htmlspecialchars(BLOG_TITLE) ?></h3>
                <p><?= htmlspecialchars(BLOG_DESCRIPTION) ?></p>
            </div>
            <p class="copyright">&copy; <?= date('Y') ?> <?= htmlspecialchars(BLOG_TITLE) ?>. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
