<?php

class StandingController extends Controller
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
        $teamModel = new Team();
        $matchModel = new MatchModel();

        $tournament = $tournamentModel->findOwned($tournamentId, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Tournoi introuvable');
            $this->redirect('tournaments');
        }

        $teams = $teamModel->getByTournament($tournamentId, Auth::id());
        $matches = $matchModel->getByTournament($tournamentId, Auth::id());

        // 🔥 INIT AVEC LOGO (FIX)
        $standings = [];

        foreach ($teams as $team) {
            $standings[] = [
                'team_id' => (int) $team['id'],
                'team_name' => $team['name'],
                'logo' => $team['logo'] ?? 'logo1.png', // 🔥 FIX ICI
                'played' => 0,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'goals_for' => 0,
                'goals_against' => 0,
                'goal_difference' => 0,
                'points' => 0,
            ];
        }

        // 🔥 CALCUL
        foreach ($matches as $match) {

            if ($match['status'] !== 'finished') continue;
            if ($match['score1'] === null || $match['score2'] === null) continue;

            $team1Id = (int) $match['team1_id'];
            $team2Id = (int) $match['team2_id'];

            $score1 = (int) $match['score1'];
            $score2 = (int) $match['score2'];

            foreach ($standings as &$team) {

                if ($team['team_id'] === $team1Id || $team['team_id'] === $team2Id) {

                    $team['played']++;

                    if ($team['team_id'] === $team1Id) {

                        $team['goals_for'] += $score1;
                        $team['goals_against'] += $score2;

                        if ($score1 > $score2) {
                            $team['wins']++;
                            $team['points'] += 3;
                        } elseif ($score1 < $score2) {
                            $team['losses']++;
                        } else {
                            $team['draws']++;
                            $team['points'] += 1;
                        }

                    } else {

                        $team['goals_for'] += $score2;
                        $team['goals_against'] += $score1;

                        if ($score2 > $score1) {
                            $team['wins']++;
                            $team['points'] += 3;
                        } elseif ($score2 < $score1) {
                            $team['losses']++;
                        } else {
                            $team['draws']++;
                            $team['points'] += 1;
                        }
                    }
                }
            }
            unset($team);
        }

        // 🔥 DIFF
        foreach ($standings as &$row) {
            $row['goal_difference'] = $row['goals_for'] - $row['goals_against'];
        }
        unset($row);

        // 🔥 TRI PRO
        usort($standings, function ($a, $b) {
            return
                ($b['points'] <=> $a['points']) ?:
                ($b['goal_difference'] <=> $a['goal_difference']) ?:
                ($b['goals_for'] <=> $a['goals_for']) ?:
                strcmp($a['team_name'], $b['team_name']);
        });

        // 🔥 POSITION
        $position = 1;
        $last = null;

        foreach ($standings as &$row) {

            if (
                $last &&
                $row['points'] === $last['points'] &&
                $row['goal_difference'] === $last['goal_difference'] &&
                $row['goals_for'] === $last['goals_for']
            ) {
                $row['position'] = $last['position'];
            } else {
                $row['position'] = $position;
            }

            $last = $row;
            $position++;
        }
        unset($row);

        $this->view('standings/index', [
            'tournament' => $tournament,
            'standings' => $standings,
        ]);
    }
}