<?php
return [
    '/' => 'Source\\Controllers\\HomeController@index',

    // ==============================
    // AUTHENTICATION
    // ==============================
    '/auth' => 'Source\\Controllers\\AuthController@auth',
    '/logout' => 'Source\\Controllers\\AuthController@logout',
    '/auth_action' => 'Source\\Controllers\\AuthController@authenticate',
];
