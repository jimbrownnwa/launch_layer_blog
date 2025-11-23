<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * POSTS_PER_PAGE;
$posts = getRecentPosts(POSTS_PER_PAGE, $offset);
$totalPosts = getTotalPosts();
$totalPages = ceil($totalPosts / POSTS_PER_PAGE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(BLOG_TITLE) ?></title>
    <meta name="description" content="<?= htmlspecialchars(BLOG_DESCRIPTION) ?>">
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
                    <a href="#posts">Articles</a>
                    <a href="#about">About</a>
                    <a href="#subscribe" class="btn-primary">Get Updates</a>
                </nav>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Business principles that work.<br><span class="gradient-text">Frameworks that scale.</span></h2>
            <p><?= htmlspecialchars(BLOG_DESCRIPTION) ?></p>
            <div class="hero-buttons">
                <a href="#posts" class="btn-primary">Read Articles</a>
                <a href="#about" class="btn-secondary">Learn More</a>
            </div>
        </div>
    </section>

    <section class="features" id="about">
        <div class="container">
            <div class="features-header">
                <h2>Why Launch Layer Blog?</h2>
                <p>Proven frameworks and actionable insights for small business success.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon blue">&#9889;</div>
                    <h3>Actionable Insights</h3>
                    <p>Every article delivers practical strategies you can implement immediately to improve your operations.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon cyan">&#9650;</div>
                    <h3>Proven Frameworks</h3>
                    <p>Learn established principles like Lean, Six Sigma, and OKRs adapted specifically for small businesses.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon orange">&#9733;</div>
                    <h3>Curated Resources</h3>
                    <p>Each post includes recommended books and tools to deepen your knowledge and accelerate growth.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="posts-section" id="posts">
        <div class="container">
            <div class="section-header">
                <h2>Latest Articles</h2>
                <p>Fresh insights to help you build and scale your business.</p>
            </div>
            <div class="container-narrow">
                <?php if (empty($posts)): ?>
                    <div class="no-posts">
                        <p>No posts yet. Check back soon!</p>
                    </div>
                <?php else: ?>
                    <div class="posts-list">
                        <?php foreach ($posts as $post): ?>
                            <article class="post-preview">
                                <h2><a href="post.php?slug=<?= htmlspecialchars($post['slug']) ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
                                <time datetime="<?= $post['created_at'] ?>"><?= date('F j, Y', strtotime($post['created_at'])) ?></time>
                                <p><?= htmlspecialchars($post['meta_description']) ?></p>
                                <a href="post.php?slug=<?= htmlspecialchars($post['slug']) ?>" class="read-more">Read More &rarr;</a>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($totalPages > 1): ?>
                        <nav class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?= $page - 1 ?>" class="prev">&larr; Previous</a>
                            <?php endif; ?>

                            <span class="page-info">Page <?= $page ?> of <?= $totalPages ?></span>

                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?= $page + 1 ?>" class="next">Next &rarr;</a>
                            <?php endif; ?>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

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
