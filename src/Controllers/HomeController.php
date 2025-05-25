<?php

namespace Source\Controllers;

use Source\Models\Post;
use Source\Models\User;
use Core\View;

class HomeController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];

            $posts = Post::where('user_id', $user_id)->get();

            $user = User::find($user_id);

            View::render('home', [
                'posts' => $posts,
                'user_logged_in' => true,
                'user_name' => $user->name,
            ]);
        } else {
            View::render('home', [
                'message' => 'You are not logged in.',
                'user_logged_in' => false,
            ]);
        }
    }

    public function notFound()
    {
        http_response_code(404);
        View::render('404', [
            'message' => 'Page not found.',
        ]);
    }
}
