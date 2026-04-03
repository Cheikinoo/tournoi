<?php

class Team extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GET TEAMS BY TOURNAMENT
    |--------------------------------------------------------------------------
    */
    public function getByTournament(int $tournamentId, int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT t.id, t.name, t.logo
            FROM teams t
            JOIN tournaments tr ON t.tournament_id = tr.id
            WHERE t.tournament_id = :tournament_id
              AND tr.user_id = :user_id
            ORDER BY t.id ASC
        ");

        $stmt->execute([
            'tournament_id' => $tournamentId,
            'user_id' => $userId
        ]);

        return $stmt->fetchAll() ?: [];
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE TEAM (🔥 VERSION FIX + LOGO)
    |--------------------------------------------------------------------------
    */
    public function create(array $data): int
    {
        if (empty($data['name']) || empty($data['tournament_id'])) {
            return 0;
        }

        $name = trim($data['name']);
        $logo = $data['logo'] ?? 'logo1.png';

        // 🔒 sécurité : whitelist logos
        $allowedLogos = array_map(fn($i) => "logo$i.png", range(1, 20));
        if (!in_array($logo, $allowedLogos)) {
            $logo = 'logo1.png';
        }

        // 🔒 vérifier ownership tournoi
        $check = $this->db->prepare("
            SELECT id FROM tournaments
            WHERE id = :id AND user_id = :user_id
            LIMIT 1
        ");

        $check->execute([
            'id' => $data['tournament_id'],
            'user_id' => Auth::id()
        ]);

        if (!$check->fetch()) {
            return 0;
        }

        // 🔒 éviter doublons
        $exists = $this->db->prepare("
            SELECT id FROM teams
            WHERE tournament_id = :tournament_id
              AND LOWER(name) = LOWER(:name)
            LIMIT 1
        ");

        $exists->execute([
            'tournament_id' => $data['tournament_id'],
            'name' => $name
        ]);

        if ($exists->fetch()) {
            return 0;
        }

        // 🔥 FIX MAJEUR : ajout logo
        $stmt = $this->db->prepare("
            INSERT INTO teams (tournament_id, name, logo)
            VALUES (:tournament_id, :name, :logo)
        ");

        $success = $stmt->execute([
            'tournament_id' => $data['tournament_id'],
            'name' => $name,
            'logo' => $logo
        ]);

        if (!$success) {
            return 0;
        }

        return (int) $this->db->lastInsertId();
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE TEAM
    |--------------------------------------------------------------------------
    */
    public function delete(int $teamId, int $userId): bool
    {
        $stmt = $this->db->prepare("
            DELETE t FROM teams t
            JOIN tournaments tr ON t.tournament_id = tr.id
            WHERE t.id = :id AND tr.user_id = :user_id
        ");

        return $stmt->execute([
            'id' => $teamId,
            'user_id' => $userId
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FIND TEAM
    |--------------------------------------------------------------------------
    */
    public function find(int $teamId, int $userId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT t.id, t.name, t.logo
            FROM teams t
            JOIN tournaments tr ON t.tournament_id = tr.id
            WHERE t.id = :id AND tr.user_id = :user_id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $teamId,
            'user_id' => $userId
        ]);

        return $stmt->fetch() ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT BY TOURNAMENT
    |--------------------------------------------------------------------------
    */
    public function countByTournament(int $tournamentId, int $userId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM teams t
            JOIN tournaments tr ON t.tournament_id = tr.id
            WHERE t.tournament_id = :tournament_id
              AND tr.user_id = :user_id
        ");

        $stmt->execute([
            'tournament_id' => $tournamentId,
            'user_id' => $userId
        ]);

        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT BY USER
    |--------------------------------------------------------------------------
    */
    public function countByUser(int $userId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM teams t
            JOIN tournaments tr ON t.tournament_id = tr.id
            WHERE tr.user_id = :user_id
        ");

        $stmt->execute([
            'user_id' => $userId
        ]);

        return (int) ($stmt->fetch()['total'] ?? 0);
    }
}