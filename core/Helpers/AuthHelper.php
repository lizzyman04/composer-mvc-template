<?php

namespace Core\Helpers;

use Core\View;
use Source\Models\User;

class AuthHelper
{
    /**
     * Ensures the session is started.
     */
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Checks if the user is authenticated.
     *
     * @return User|null Returns the authenticated user or null if authentication fails
     */
    public static function check()
    {
        self::start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth');
            exit;
        }

        $user = User::find($_SESSION['user_id']);
        if (!$user) {
            session_destroy();
            header('Location: /auth');
            exit;
        }

        return $user;
    }

    /**
     * Validates login credentials (email or phone, and password).
     *
     * @param string|null $email
     * @param string|null $phone
     * @param string $password
     * @return array Validation result with 'isValid' and 'error' (if any)
     */
    public static function validate(?string $email, ?string $phone, string $password): array
    {
        if (empty($email) && empty($phone)) {
            return ['isValid' => false, 'error' => 'Email or phone must be provided.'];
        }

        if (empty($password)) {
            return ['isValid' => false, 'error' => 'Password is required.'];
        }

        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['isValid' => false, 'error' => 'Invalid email.'];
        }

        if ($phone && !preg_match('/^\+?[1-9]\d{1,14}$/', $phone)) {
            return ['isValid' => false, 'error' => 'Invalid phone number.'];
        }

        return ['isValid' => true, 'error' => null];
    }
}