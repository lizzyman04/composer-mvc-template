<?php

namespace Source\Controllers;

use Core\Helpers\AuthHelper;
use Source\Models\Post;
use Source\Models\User;
use Core\View;

class HomeController
{
    public function index()
    {
        $user = AuthHelper::check();

        if ($user) {
            $posts = Post::where('user_id', $user->id)->get();
            View::render('home', [
                'title' => 'Home',
                'posts' => $posts,
                'user_logged_in' => true,
                'user_name' => $user->name,
            ]);
        } else {
            View::render('home', [
                'title' => 'Home',
                'message' => 'You are not logged in.',
                'user_logged_in' => false,
            ]);
        }
    }

    public function notFound()
    {
        http_response_code(404);
        View::render('404', [
            'title' => 'Page Not Found',
            'message' => 'Page not found.',
        ]);
    }
}