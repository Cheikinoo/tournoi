<?php

class MatchController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $tournamentId = (int) ($_GET['tournament_id'] ?? 0);

        if ($tournamentId <= 0) {
            setFlash('error', 'Tournoi invalide');
            $this->redirect('dashboard');
        }

        $tournamentModel = new Tournament();
        $matchModel = new MatchModel();

        $tournament = $tournamentModel->findOwned($tournamentId, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Tournoi introuvable');
            $this->redirect('tournaments');
        }

        $matches = $matchModel->getByTournament($tournamentId, Auth::id());

        $this->view('matches/index', compact('tournament', 'matches'));
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE MATCHES (🔥 VERSION CLEAN)
    |--------------------------------------------------------------------------
    */
    public function generate(): void
    {
        Auth::requireLogin();

        if (!verifyCsrf()) {
            $this->abort(403, 'CSRF invalide');
        }

        $tournamentId = (int) ($_POST['tournament_id'] ?? 0);

        if ($tournamentId <= 0) {
            setFlash('error', 'Tournoi invalide');
            $this->redirect('dashboard');
        }

        $tournamentModel = new Tournament();
        $teamModel = new Team();
        $matchModel = new MatchModel();

        $tournament = $tournamentModel->findOwned($tournamentId, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Accès refusé');
            $this->redirect('tournaments');
        }

        $teams = $teamModel->getByTournament($tournamentId, Auth::id());

        if (count($teams) < 2) {
            setFlash('error', 'Minimum 2 équipes');
            $this->redirect('teams&tournament_id=' . $tournamentId);
        }

        $db = Database::connect();

        try {
            $db->beginTransaction();

            // 🔥 clean reset
            $matchModel->clearByTournament($tournamentId, Auth::id());

            // 🔥 round robin simple
            for ($i = 0; $i < count($teams); $i++) {
                for ($j = $i + 1; $j < count($teams); $j++) {

                    $matchModel->create([
                        'tournament_id' => $tournamentId,
                        'team1_id' => (int) $teams[$i]['id'],
                        'team2_id' => (int) $teams[$j]['id'],
                    ]);
                }
            }

            $db->commit();

        } catch (Exception $e) {

            $db->rollBack();

            setFlash('error', 'Erreur génération matchs');
            $this->back();
        }

        setFlash('success', 'Matchs générés 🔥');

        $this->redirect('matches&tournament_id=' . $tournamentId);
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT SCORE
    |--------------------------------------------------------------------------
    */
    public function editScore(): void
    {
        Auth::requireLogin();

        $matchId = (int) ($_GET['id'] ?? 0);

        if ($matchId <= 0) {
            setFlash('error', 'Match invalide');
            $this->redirect('dashboard');
        }

        $matchModel = new MatchModel();
        $match = $matchModel->find($matchId, Auth::id());

        if (!$match) {
            setFlash('error', 'Match introuvable');
            $this->redirect('dashboard');
        }

        $tournamentModel = new Tournament();
        $tournament = $tournamentModel->findOwned((int) $match['tournament_id'], Auth::id());

        if (!$tournament) {
            setFlash('error', 'Accès refusé');
            $this->redirect('tournaments');
        }

        $this->view('matches/edit_score', compact('match', 'tournament'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SCORE (🔥 FIX TOTAL)
    |--------------------------------------------------------------------------
    */
    public function updateScore(): void
    {
        Auth::requireLogin();

        if (!verifyCsrf()) {
            $this->abort(403, 'CSRF invalide');
        }

        $matchId = (int) ($_POST['id'] ?? 0);
        $score1 = max(0, (int) ($_POST['score1'] ?? 0));
        $score2 = max(0, (int) ($_POST['score2'] ?? 0));

        if ($matchId <= 0) {
            setFlash('error', 'Match invalide');
            $this->redirect('dashboard');
        }

        $matchModel = new MatchModel();

        // 🔥 sécurisé
        $match = $matchModel->find($matchId, Auth::id());

        if (!$match) {
            setFlash('error', 'Match introuvable');
            $this->redirect('dashboard');
        }

        $success = $matchModel->updateScore(
            $matchId,
            Auth::id(),
            $score1,
            $score2
        );

        if (!$success) {
            setFlash('error', 'Erreur mise à jour');
            $this->back();
        }

        setFlash('success', 'Score enregistré ✅');

        $this->redirect('matches&tournament_id=' . $match['tournament_id']);
    }
}