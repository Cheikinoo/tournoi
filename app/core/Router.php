<?php

define('APP_DEBUG', true); // 🔥 dev
// define('APP_DEBUG', false); // 🔒 prod
class Router
{
    private array $getRoutes = [];
    private array $postRoutes = [];

    /*
    |--------------------------------------------------------------------------
    | REGISTER ROUTES
    |--------------------------------------------------------------------------
    */
    public function get(string $route, array $action): void
    {
        $this->getRoutes[$this->normalize($route)] = $action;
    }

    public function post(string $route, array $action): void
    {
        $this->postRoutes[$this->normalize($route)] = $action;
    }

    /*
    |--------------------------------------------------------------------------
    | DISPATCH
    |--------------------------------------------------------------------------
    */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // 🔥 route par défaut
        $url = $_GET['url'] ?? 'home';
        $url = $this->normalize($url);

        $routes = $method === 'POST' ? $this->postRoutes : $this->getRoutes;

        if (!isset($routes[$url])) {
            $this->handle404();
            return;
        }

        [$controllerClass, $methodName] = $routes[$url];

        // 🔒 sécurité
        if (!class_exists($controllerClass)) {
            $this->handle404();
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $methodName)) {
            $this->handle404();
            return;
        }

        try {
            $controller->$methodName();
        } catch (Throwable $e) {

            // 🔥 debug (désactive en prod)
            if (APP_DEBUG) {
                echo "<pre>";
                echo "Erreur : " . $e->getMessage();
                echo "\nFichier : " . $e->getFile();
                echo "\nLigne : " . $e->getLine();
                echo "</pre>";
            } else {
                $this->handle500();
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALIZE URL
    |--------------------------------------------------------------------------
    */
    private function normalize(string $url): string
    {
        return trim(strtolower($url), '/');
    }

    /*
    |--------------------------------------------------------------------------
    | 404
    |--------------------------------------------------------------------------
    */
    private function handle404(): void
    {
        http_response_code(404);

        echo '
        <div style="font-family:sans-serif;text-align:center;margin-top:50px;">
            <h1>404</h1>
            <p>Page introuvable</p>
            <a href="index.php?url=home">Retour à l\'accueil</a>
        </div>
        ';
    }

    /*
    |--------------------------------------------------------------------------
    | 500
    |--------------------------------------------------------------------------
    */
    private function handle500(): void
    {
        http_response_code(500);

        echo '
        <div style="font-family:sans-serif;text-align:center;margin-top:50px;">
            <h1>500</h1>
            <p>Erreur serveur</p>
        </div>
        ';
    }
}