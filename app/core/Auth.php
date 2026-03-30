<?php

class Auth
{
    /*
    |--------------------------------------------------------------------------
    | CHECK
    |--------------------------------------------------------------------------
    */
    public static function check(): bool
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | ID
    |--------------------------------------------------------------------------
    */
    public static function id(): ?int
    {
        return $_SESSION['user']['id'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */
    public static function login(array $user): void
    {
        // 🔒 sécurité session
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'] ?? '',
            'email' => $user['email'] ?? '',
            'role' => $user['role'] ?? 'user',
        ];

        // 🔥 option : timestamp
        $_SESSION['last_activity'] = time();
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public static function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    /*
    |--------------------------------------------------------------------------
    | REQUIRE LOGIN
    |--------------------------------------------------------------------------
    */
    public static function requireLogin(): void
    {
        if (!self::check()) {
            setFlash('error', 'Vous devez être connecté.');
            header('Location: ' . BASE_URL . '/index.php?url=login');
            exit;
        }

        // 🔥 session timeout (30 min)
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 1800) {
            self::logout();
            setFlash('error', 'Session expirée');
            header('Location: ' . BASE_URL . '/index.php?url=login');
            exit;
        }

        $_SESSION['last_activity'] = time();
    }

    /*
    |--------------------------------------------------------------------------
    | REQUIRE ROLE (🔥 admin futur)
    |--------------------------------------------------------------------------
    */
    public static function requireRole(string $role): void
    {
        if (!self::check() || ($_SESSION['user']['role'] ?? '') !== $role) {
            setFlash('error', 'Accès refusé');
            header('Location: ' . BASE_URL . '/index.php?url=dashboard');
            exit;
        }
    }
}