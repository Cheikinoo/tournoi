<?php

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('dashboard');
        }

        // 🔥 Générer CSRF si pas existant
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }

        $this->view('auth/login');
    }

    public function login(): void
    {
        // 🔒 CSRF CHECK
        if (
            !isset($_POST['csrf'], $_SESSION['csrf']) ||
            !hash_equals($_SESSION['csrf'], $_POST['csrf'])
        ) {
            setFlash('error', 'Requête invalide.');
            $this->redirect('login');
        }

        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = trim($_POST['password'] ?? '');

        // 🔥 VALIDATION
        if (!required($email) || !required($password)) {
            setFlash('error', 'Tous les champs sont obligatoires.');
            $this->redirect('login');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlash('error', 'Email invalide.');
            $this->redirect('login');
        }

        $userModel = new User();

        try {
            $user = $userModel->findByEmail($email);
        } catch (Exception $e) {
            setFlash('error', 'Erreur serveur.');
            $this->redirect('login');
        }

        if (!$user || !password_verify($password, $user['password_hash'])) {
            setFlash('error', 'Email ou mot de passe incorrect.');
            $this->redirect('login');
        }

        // 🔐 LOGIN SECURE
        Auth::login([
            'id' => (int) $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);

        // 🔥 Regénérer CSRF après login
        $_SESSION['csrf'] = bin2hex(random_bytes(32));

        setFlash('success', 'Connexion réussie 🚀');

        $this->redirect('dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    public function showRegister(): void
    {
        if (Auth::check()) {
            $this->redirect('dashboard');
        }

        // 🔥 CSRF
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }

        $this->view('auth/register');
    }

    public function register(): void
    {
        // 🔒 CSRF CHECK
        if (
            !isset($_POST['csrf'], $_SESSION['csrf']) ||
            !hash_equals($_SESSION['csrf'], $_POST['csrf'])
        ) {
            setFlash('error', 'Requête invalide.');
            $this->redirect('register');
        }

        $name = trim($_POST['name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = trim($_POST['password'] ?? '');

        // 🔥 VALIDATION
        if (!required($name) || !required($email) || !required($password)) {
            setFlash('error', 'Tous les champs sont obligatoires.');
            $this->redirect('register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            setFlash('error', 'Email invalide.');
            $this->redirect('register');
        }

        if (strlen($password) < 6) {
            setFlash('error', 'Mot de passe trop court (min 6 caractères)');
            $this->redirect('register');
        }

        $userModel = new User();

        try {
            if ($userModel->emailExists($email)) {
                setFlash('error', 'Email déjà utilisé.');
                $this->redirect('register');
            }

            $userModel->create([
                'name' => $name,
                'email' => $email,
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'user',
            ]);

        } catch (Exception $e) {
            setFlash('error', 'Erreur serveur.');
            $this->redirect('register');
        }

        // 🔥 Regénérer CSRF
        $_SESSION['csrf'] = bin2hex(random_bytes(32));

        setFlash('success', 'Compte créé 🎉');

        $this->redirect('login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(): void
    {
        Auth::logout();

        // 🔥 reset CSRF
        $_SESSION['csrf'] = bin2hex(random_bytes(32));

        setFlash('success', 'Déconnexion réussie');

        $this->redirect('login');
    }
}