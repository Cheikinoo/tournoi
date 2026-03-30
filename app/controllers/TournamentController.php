<?php

class TournamentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(): void
    {
        Auth::requireLogin();

        $model = new Tournament();
        $tournaments = $model->allByUser(Auth::id());

        $this->view('tournaments/index', compact('tournaments'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create(): void
    {
        Auth::requireLogin();
        $this->view('tournaments/create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (🔥 VERSION PRO)
    |--------------------------------------------------------------------------
    */
    public function store(): void
    {
        Auth::requireLogin();

        if (!verifyCsrf()) {
            $this->abort(403, 'CSRF invalide');
        }

        // 🔥 garder les anciennes valeurs
        setOld($_POST);

        // 🔥 validation
        $name = trim($_POST['name'] ?? '');

        if (!required($name) || !minLength($name, 2)) {
            setFlash('error', 'Nom invalide (min 2 caractères)');
            $this->back();
        }

        // 🔥 nettoyage sécurisé
        $format = $_POST['format'] ?? '5v5';
        $type = $_POST['type'] ?? 'league';
        $status = $_POST['status'] ?? 'draft';
        $duration = max(1, (int) ($_POST['match_duration'] ?? 10));

        $model = new Tournament();

        $success = $model->create([
            'user_id' => Auth::id(),
            'name' => $name,
            'format' => $format,
            'type' => $type,
            'status' => $status,
            'match_duration' => $duration,
        ]);

        if (!$success) {
            setFlash('error', 'Erreur lors de la création');
            $this->back();
        }

        // 🔥 clear old si succès
        clearOld();

        setFlash('success', 'Tournoi créé 🎉');
        $this->redirect('tournaments');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(): void
    {
        Auth::requireLogin();

        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $this->redirect('tournaments');
        }

        $tournamentModel = new Tournament();
        $teamModel = new Team();
        $matchModel = new MatchModel();

        $tournament = $tournamentModel->findOwned($id, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Tournoi introuvable');
            $this->redirect('tournaments');
        }

        $teams = $teamModel->getByTournament($id, Auth::id());
        $matches = $matchModel->getByTournament($id, Auth::id());

        $this->view('tournaments/show', compact(
            'tournament',
            'teams',
            'matches'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(): void
    {
        Auth::requireLogin();

        $id = (int) ($_GET['id'] ?? 0);

        $model = new Tournament();
        $tournament = $model->findOwned($id, Auth::id());

        if (!$tournament) {
            setFlash('error', 'Tournoi introuvable');
            $this->redirect('tournaments');
        }

        $this->view('tournaments/edit', compact('tournament'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE (🔥 VERSION PRO)
    |--------------------------------------------------------------------------
    */
    public function update(): void
    {
        Auth::requireLogin();

        if (!verifyCsrf()) {
            $this->abort(403, 'CSRF invalide');
        }

        setOld($_POST);

        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');

        if ($id <= 0 || !required($name) || !minLength($name, 2)) {
            setFlash('error', 'Données invalides');
            $this->back();
        }

        $model = new Tournament();

        $success = $model->update([
            'id' => $id,
            'user_id' => Auth::id(),
            'name' => $name,
            'format' => $_POST['format'] ?? '5v5',
            'type' => $_POST['type'] ?? 'league',
            'status' => $_POST['status'] ?? 'draft',
            'match_duration' => max(1, (int) ($_POST['match_duration'] ?? 10)),
        ]);

        if (!$success) {
            setFlash('error', 'Erreur lors de la mise à jour');
            $this->back();
        }

        clearOld();

        setFlash('success', 'Tournoi mis à jour');
        $this->redirect('tournaments');
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
            $this->abort(403, 'CSRF invalide');
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            setFlash('error', 'ID invalide');
            $this->back();
        }

        $model = new Tournament();

        $success = $model->delete($id, Auth::id());

        if (!$success) {
            setFlash('error', 'Erreur suppression');
            $this->back();
        }

        setFlash('success', 'Tournoi supprimé');
        $this->redirect('tournaments');
    }
}