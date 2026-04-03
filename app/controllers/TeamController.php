<?php

class TeamController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
public function index(): void
{
    Auth::requireLogin();

    $tournamentId = (int) ($_GET['tournament_id'] ?? 0);

    // 🔥 FIX UX : redirection propre si pas d'id
    if ($tournamentId <= 0) {
        setFlash('error', 'Veuillez sélectionner un tournoi');
        $this->redirect('tournaments');
    }

    $tournamentModel = new Tournament();
    $teamModel = new Team();

    $tournament = $tournamentModel->findOwned($tournamentId, Auth::id());

    // 🔒 sécurité
    if (!$tournament) {
        setFlash('error', 'Tournoi introuvable ou accès refusé');
        $this->redirect('tournaments');
    }

    $teams = $teamModel->getByTournament($tournamentId, Auth::id());

    $this->view('teams/index', [
        'tournament' => $tournament,
        'teams' => $teams
    ]);
}
    /*
    |--------------------------------------------------------------------------
    | STORE (🔥 VERSION AVEC LOGO)
    |--------------------------------------------------------------------------
    */
    public function store(): void
    {
        Auth::requireLogin();

        // 🔒 CSRF
        if (!verifyCsrf()) {
            http_response_code(403);
            die('CSRF invalide');
        }

        $name = trim($_POST['team_name'] ?? '');
        $logo = $_POST['logo'] ?? 'logo1.png';
        $tournamentId = (int) ($_POST['tournament_id'] ?? 0);

        if (!$name || strlen($name) < 2) {
            setFlash('error', 'Nom invalide (min 2 caractères)');
            $this->back();
        }

        if ($tournamentId <= 0) {
            setFlash('error', 'Tournoi invalide');
            $this->back();
        }

        $tournamentModel = new Tournament();
        $teamModel = new Team();

        // 🔒 sécurité
        $tournament = $tournamentModel->findOwned($tournamentId, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Accès refusé');
            $this->redirect('tournaments');
        }

        $success = $teamModel->create([
            'name' => $name,
            'logo' => $logo,
            'tournament_id' => $tournamentId
        ]);

        if (!$success) {
            setFlash('error', 'Erreur création équipe');
            $this->back();
        }

        setFlash('success', 'Équipe ajoutée 🔥');

        // 🔥 UX : retour sur le tournoi
        $this->redirect('tournaments/show&id=' . $tournamentId);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete(): void
    {
        Auth::requireLogin();

        if (!verifyCsrf()) {
            http_response_code(403);
            die('CSRF invalide');
        }

        $teamId = (int) ($_POST['id'] ?? 0);
        $tournamentId = (int) ($_POST['tournament_id'] ?? 0);

        if ($teamId <= 0 || $tournamentId <= 0) {
            setFlash('error', 'Données invalides');
            $this->redirect('dashboard');
        }

        $teamModel = new Team();
        $tournamentModel = new Tournament();

        $tournament = $tournamentModel->findOwned($tournamentId, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Accès refusé');
            $this->redirect('tournaments');
        }

        $success = $teamModel->delete($teamId, Auth::id());

        if (!$success) {
            setFlash('error', 'Erreur suppression');
            $this->back();
        }

        setFlash('success', 'Équipe supprimée');

        $this->redirect('tournaments/show&id=' . $tournamentId);
    }
}