<?php

namespace Source\Controllers;

use Source\Models\User;
use Core\View;

class AuthController
{
    public function auth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        View::render('auth');
    }

    public function authenticate()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_POST['action'] ?? '';

        switch ($action) {
            case 'login':
                echo json_encode($this->handleLogin());
                break;
            case 'register':
                echo json_encode($this->handleRegister());
                break;
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid action.']);
        }
    }

    private function handleLogin()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            return ['success' => true, 'redirect' => '/'];
        }

        http_response_code(401);
        return ['error' => 'Invalid credentials.'];
    }

    private function handleRegister()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (User::where('email', $email)->exists()) {
            http_response_code(409);
            return ['error' => 'User already exists.'];
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);

        $_SESSION['user_id'] = $user->id;
        return ['success' => true, 'redirect' => '/'];
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: /');
    }
}
