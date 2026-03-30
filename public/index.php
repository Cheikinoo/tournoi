<?php

session_start();

/*
|--------------------------------------------------------------------------
| CONFIG
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../config/config.php';

/*
|--------------------------------------------------------------------------
| CORE CLASSES
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Auth.php';
require_once __DIR__ . '/../app/core/Helpers.php';

/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| AUTOLOAD
|--------------------------------------------------------------------------
*/
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

/*
|--------------------------------------------------------------------------
| ROUTER
|--------------------------------------------------------------------------
*/
$router = new Router();

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Landing
$router->get('', [HomeController::class, 'index']);
$router->get('home', [HomeController::class, 'index']); // 🔥 FIX 404

// Auth
$router->get('login', [AuthController::class, 'showLogin']);
$router->post('login', [AuthController::class, 'login']);
$router->get('register', [AuthController::class, 'showRegister']);
$router->post('register', [AuthController::class, 'register']);
$router->get('logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

// Dashboard
$router->get('dashboard', [DashboardController::class, 'index']);

// Tournaments
$router->get('tournaments', [TournamentController::class, 'index']);
$router->get('tournaments/create', [TournamentController::class, 'create']);
$router->post('tournaments/store', [TournamentController::class, 'store']);
$router->get('tournaments/show', [TournamentController::class, 'show']);
$router->get('tournaments/edit', [TournamentController::class, 'edit']);
$router->post('tournaments/update', [TournamentController::class, 'update']);
$router->post('tournaments/delete', [TournamentController::class, 'delete']);

// Teams
$router->get('teams', [TeamController::class, 'index']);
$router->post('teams/store', [TeamController::class, 'store']);
$router->post('teams/delete', [TeamController::class, 'delete']);

// Matches
$router->get('matches', [MatchController::class, 'index']);
$router->post('matches/generate', [MatchController::class, 'generate']);
$router->get('matches/editScore', [MatchController::class, 'editScore']);
$router->post('matches/updateScore', [MatchController::class, 'updateScore']);

// Standings
$router->get('standings', [StandingController::class, 'index']);

/*
|--------------------------------------------------------------------------
| DISPATCH
|--------------------------------------------------------------------------
*/
$router->dispatch();