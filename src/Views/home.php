<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="<?= BASE_URL ?>assets/js/home.js" defer></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/home.css">
</head>
<body>
    <h1>Welcome to the Blog</h1>

    <?php if ($user_logged_in): ?>
        <p class="auth-message">Logged in as <?= htmlspecialchars($user_name) ?>!</p>
        <h2>Your Blogs</h2>

        <p class="<?= count($posts) === 0 ? 'no-posts' : 'post-message' ?>">
            <?= count($posts) === 0 ? 'No blogs yet.' : '' ?>
        </p>

        <?php if (count($posts) > 0): ?>
            <ul>
                <?php foreach ($posts as $post): ?>
                    <li>
                        <h3><?= htmlspecialchars($post->title) ?></h3>
                        <p><?= nl2br(htmlspecialchars($post->content)) ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <a href="/new_post" class="post-link">Post a new blog</a>
        <a href="/logout" class="logout-link">Logout</a>

    <?php else: ?>
        <p class="auth-message"><?= htmlspecialchars($message) ?></p>
        <a href="/auth" class="auth-link">Login</a> or <a href="/auth" class="auth-link">Register</a>
    <?php endif; ?>

</body>
</html>