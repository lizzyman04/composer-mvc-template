<?php
$title = $post->title;
ob_start();
?>
<div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
    <div class="container mx-auto p-6 max-w-2xl">
        <div class="bg-white rounded-lg shadow-card p-8">
            <h1 class="text-3xl font-heading font-bold text-gray-800 mb-4"><?= htmlspecialchars($post->title) ?></h1>
            <p class="text-gray-600 font-body mb-6"><?= nl2br(htmlspecialchars($post->content)) ?></p>
            <div class="flex justify-end space-x-4">
                <a href="/posts/<?= $post->id ?>/edit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">Edit</a>
                <button data-id="<?= $post->id ?>"
                    class="delete-post bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition duration-200 font-semibold">Delete</button>
                <a href="/"
                    class="bg-gray-300 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-400 transition duration-200 font-semibold">Back
                    to Home</a>
            </div>
        </div>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/post.js" defer></script>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/main.php';
?>