<?php

class Player extends Model
{
    /*
    |--------------------------------------------------------------------------
    | CREATE PLAYER (VERSION EXPERT)
    |--------------------------------------------------------------------------
    */
    public function create(array $data): bool
    {
        // 🔒 validation minimale
        if (empty($data['team_id']) || empty($data['name'])) {
            return false;
        }

        $name = trim($data['name']);
        $number = isset($data['number']) ? (int)$data['number'] : null;

        // 🔒 éviter doublon joueur dans une équipe
        $exists = $this->db->prepare("
            SELECT id FROM players
            WHERE team_id = :team_id
              AND LOWER(name) = LOWER(:name)
            LIMIT 1
        ");

        $exists->execute([
            'team_id' => $data['team_id'],
            'name' => $name
        ]);

        if ($exists->fetch()) {
            return false;
        }

        // 🔒 éviter doublon numéro (optionnel mais pro)
        if ($number !== null) {
            $checkNumber = $this->db->prepare("
                SELECT id FROM players
                WHERE team_id = :team_id
                  AND number = :number
                LIMIT 1
            ");

            $checkNumber->execute([
                'team_id' => $data['team_id'],
                'number' => $number
            ]);

            if ($checkNumber->fetch()) {
                return false;
            }
        }

        $stmt = $this->db->prepare("
            INSERT INTO players (team_id, name, number)
            VALUES (:team_id, :name, :number)
        ");

        return $stmt->execute([
            'team_id' => $data['team_id'],
            'name' => $name,
            'number' => $number
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GET PLAYERS BY TEAM
    |--------------------------------------------------------------------------
    */
    public function getByTeam(int $teamId): array
    {
        $stmt = $this->db->prepare("
            SELECT id, name, number
            FROM players
            WHERE team_id = :team_id
            ORDER BY number ASC, name ASC
        ");

        $stmt->execute(['team_id' => $teamId]);

        return $stmt->fetchAll() ?: [];
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PLAYER (🔥 futur)
    |--------------------------------------------------------------------------
    */
    public function delete(int $playerId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM players WHERE id = :id
        ");

        return $stmt->execute(['id' => $playerId]);
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT PLAYERS BY TEAM
    |--------------------------------------------------------------------------
    */
    public function countByTeam(int $teamId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM players
            WHERE team_id = :team_id
        ");

        $stmt->execute(['team_id' => $teamId]);

        return (int) ($stmt->fetch()['total'] ?? 0);
    }
}