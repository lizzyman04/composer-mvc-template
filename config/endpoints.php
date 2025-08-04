<?php
return [
    // ==============================
    // HOME
    // ==============================
    '/' => 'Source\\Controllers\\HomeController@index',

    // ==============================
    // AUTHENTICATION
    // ==============================
    '/auth' => 'Source\\Controllers\\AuthController@auth',
    '/logout' => 'Source\\Controllers\\AuthController@logout',
    '/auth_action' => 'Source\\Controllers\\AuthController@authenticate',

    // ==============================
    // POSTS
    // ==============================
    '/new-post' => 'Source\\Controllers\\PostController@create',
    '/posts/store' => 'Source\\Controllers\\PostController@store',
    '/posts/{id}' => 'Source\\Controllers\\PostController@show',
    '/posts/{id}/edit' => 'Source\\Controllers\\PostController@edit',
    '/posts/{id}/update' => 'Source\\Controllers\\PostController@update',
    '/posts/{id}/delete' => 'Source\\Controllers\\PostController@destroy',
];