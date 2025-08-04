<?php

namespace Source\Controllers;

use Core\Helpers\AuthHelper;
use Source\Models\Post;
use Core\View;

class PostController
{
    /**
     * Display the form to create a new post.
     */
    public function create()
    {
        $user = AuthHelper::check();
        View::render('modules/posts/create', [
            'title' => 'New Post',
            'user_name' => $user->name,
        ]);
    }

    /**
     * Store a new post.
     */
    public function store()
    {
        $user = AuthHelper::check();

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        if (empty($title) || empty($content)) {
            http_response_code(400);
            echo json_encode(['error' => 'Title and content are required.']);
            return;
        }

        $post = Post::create([
            'user_id' => $user->id,
            'title' => $title,
            'content' => $content,
        ]);

        echo json_encode(['success' => true, 'redirect' => '/']);
    }

    /**
     * Display a single post.
     */
    public function show($id)
    {
        $user = AuthHelper::check();
        $post = Post::find($id);

        if (!$post || $post->user_id !== $user->id) {
            http_response_code(404);
            View::render('404', ['title' => 'Post Not Found']);
            return;
        }

        View::render('modules/posts/show', [
            'title' => $post->title,
            'post' => $post,
            'user_name' => $user->name,
        ]);
    }

    /**
     * Display the form to edit a post.
     */
    public function edit($id)
    {
        $user = AuthHelper::check();
        $post = Post::find($id);

        if (!$post || $post->user_id !== $user->id) {
            http_response_code(404);
            View::render('404', ['title' => 'Post Not Found']);
            return;
        }

        View::render('modules/posts/edit', [
            'title' => 'Edit Post',
            'post' => $post,
            'user_name' => $user->name,
        ]);
    }

    /**
     * Update an existing post.
     */
    public function update($id)
    {
        $user = AuthHelper::check();
        $post = Post::find($id);

        if (!$post || $post->user_id !== $user->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Post not found.']);
            return;
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        if (empty($title) || empty($content)) {
            http_response_code(400);
            echo json_encode(['error' => 'Title and content are required.']);
            return;
        }

        $post->update([
            'title' => $title,
            'content' => $content,
        ]);

        echo json_encode(['success' => true, 'redirect' => '/']);
    }

    /**
     * Delete a post.
     */
    public function destroy($id)
    {
        $user = AuthHelper::check();
        $post = Post::find($id);

        if (!$post || $post->user_id !== $user->id) {
            http_response_code(404);
            echo json_encode(['error' => 'Post not found.']);
            return;
        }

        $post->delete();
        echo json_encode(['success' => true, 'redirect' => '/']);
    }
}