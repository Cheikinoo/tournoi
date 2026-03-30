<?php

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = Auth::id();

        if (!$userId) {
            $this->redirect('login');
        }

        $tournamentModel = new Tournament();
        $teamModel = new Team();
        $matchModel = new MatchModel();

        try {

            // 🔥 STATS
            $totalTournaments = $tournamentModel->countByUser($userId);
            $totalTeams = $teamModel->countByUser($userId);
            $totalMatches = $matchModel->countByUser($userId);

        } catch (Exception $e) {

            // 🔒 sécurité prod
            if (defined('APP_DEBUG') && APP_DEBUG) {
                die($e->getMessage());
            }

            setFlash('error', 'Erreur chargement dashboard');
            $this->redirect('home');
        }

        $this->view('dashboard/index', compact(
            'totalTournaments',
            'totalTeams',
            'totalMatches'
        ));
    }
}