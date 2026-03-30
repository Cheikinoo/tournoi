<?php

class Controller
{
    /*
    |--------------------------------------------------------------------------
    | VIEW
    |--------------------------------------------------------------------------
    */
    protected function view(string $view, array $data = []): void
    {
        // 🔒 sécurise extract
        if (!empty($data)) {
            extract($data, EXTR_SKIP);
        }

        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            $this->abort(404, "Vue introuvable : " . $view);
        }

        require __DIR__ . '/../views/layouts/header.php';
        require $viewPath;
        require __DIR__ . '/../views/layouts/footer.php';
    }

    /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */
    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . '/index.php?url=' . $path);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | BACK (🔥 avec fallback propre)
    |--------------------------------------------------------------------------
    */
    protected function back(): void
    {
        $url = $_SERVER['HTTP_REFERER'] ?? (BASE_URL . '/index.php?url=dashboard');
        header('Location: ' . $url);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | JSON RESPONSE (🔥 API ready)
    |--------------------------------------------------------------------------
    */
    protected function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');

        echo json_encode([
            'status' => $status,
            'data' => $data
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | ABORT (🔥 propre)
    |--------------------------------------------------------------------------
    */
    protected function abort(int $code = 500, string $message = ''): void
    {
        http_response_code($code);

        if (defined('APP_DEBUG') && APP_DEBUG) {
            echo "<h1>$code</h1><p>$message</p>";
        } else {
            echo "<h1>$code</h1><p>Une erreur est survenue</p>";
        }

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATE (🔥 ULTRA IMPORTANT)
    |--------------------------------------------------------------------------
    */
    protected function validate(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $rule) {

            $value = $data[$field] ?? '';

            if (str_contains($rule, 'required') && !required($value)) {
                $errors[$field] = 'Champ requis';
            }

            if (str_contains($rule, 'email') && !email($value)) {
                $errors[$field] = 'Email invalide';
            }

            if (preg_match('/min:(\d+)/', $rule, $matches)) {
                $min = (int)$matches[1];
                if (!minLength($value, $min)) {
                    $errors[$field] = "Minimum $min caractères";
                }
            }
        }

        if (!empty($errors)) {
            setOld($data);
            setFlash('error', 'Veuillez corriger les erreurs');
            $this->back();
        }

        clearOld();

        return $data;
    }
}