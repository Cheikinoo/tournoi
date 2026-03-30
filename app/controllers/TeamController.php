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

        if ($tournamentId <= 0) {
            setFlash('error', 'Tournoi invalide');
            $this->redirect('dashboard');
        }

        $tournamentModel = new Tournament();
        $teamModel = new Team();

        $tournament = $tournamentModel->findOwned($tournamentId, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Tournoi introuvable');
            $this->redirect('tournaments');
        }

        $teams = $teamModel->getByTournament($tournamentId, Auth::id());

        $this->view('teams/index', compact('tournament', 'teams'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (TEAM + PLAYERS 🔥 VERSION PRO)
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

        // 🔥 VALIDATION
        $data = $this->validate($_POST, [
            'team_name' => 'required|min:2',
        ]);

        $tournamentId = (int) ($_POST['tournament_id'] ?? 0);

        if ($tournamentId <= 0) {
            setFlash('error', 'Tournoi invalide');
            $this->back();
        }

        $tournamentModel = new Tournament();
        $teamModel = new Team();
        $playerModel = new Player();

        // 🔒 SECURITY CHECK
        $tournament = $tournamentModel->findOwned($tournamentId, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Accès refusé');
            $this->redirect('tournaments');
        }

        // 🔥 TRANSACTION
        $db = Database::connect();

        try {

            $db->beginTransaction();

            // CREATE TEAM
            $teamId = $teamModel->create([
                'name' => $data['team_name'],
                'tournament_id' => $tournamentId
            ]);

            if (!$teamId) {
                throw new Exception('Erreur création équipe');
            }

            // PLAYERS
            $players = $_POST['players'] ?? [];
            $numbers = $_POST['numbers'] ?? [];

            foreach ($players as $index => $playerName) {

                $playerName = trim($playerName);
                if (!$playerName) continue;

                $number = isset($numbers[$index]) && $numbers[$index] !== ''
                    ? (int) $numbers[$index]
                    : null;

                $playerModel->create([
                    'team_id' => $teamId,
                    'name' => $playerName,
                    'number' => $number
                ]);
            }

            $db->commit();

        } catch (Exception $e) {

            $db->rollBack();

            setFlash('error', 'Erreur lors de la création');
            $this->back();
        }

        // 🔥 REGEN CSRF (FIX BUG 403)

        setFlash('success', 'Équipe + joueurs ajoutés 🔥');

        // 🔥 UX FIX (rester sur tournoi)
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

        // 🔒 CSRF
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

        // 🔒 SECURITY CHECK
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

        // 🔥 REGEN CSRF (FIX BUG 403)
        $_SESSION['csrf'] = bin2hex(random_bytes(32));

        setFlash('success', 'Équipe supprimée');

        // 🔥 UX FIX
        $this->redirect('tournaments/show&id=' . $tournamentId);
    }
}