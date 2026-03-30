<?php

class Tournament extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL BY USER
    |--------------------------------------------------------------------------
    */
    public function allByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT id, name, format, type, status, match_duration, created_at
            FROM tournaments
            WHERE user_id = :user_id
            ORDER BY id DESC
        ");

        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create(array $data): bool
    {
        if (empty($data['name']) || empty($data['user_id'])) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO tournaments (user_id, name, format, type, status, match_duration)
            VALUES (:user_id, :name, :format, :type, :status, :match_duration)
        ");

        return $stmt->execute([
            'user_id' => $data['user_id'],
            'name' => trim($data['name']),
            'format' => $data['format'] ?? '5v5',
            'type' => $data['type'] ?? 'league',
            'status' => $data['status'] ?? 'draft',
            'match_duration' => (int) ($data['match_duration'] ?? 10),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FIND
    |--------------------------------------------------------------------------
    */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, name, format, type, status, match_duration, user_id
            FROM tournaments
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | FIND OWNED
    |--------------------------------------------------------------------------
    */
    public function findOwned(int $id, int $userId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT id, name, format, type, status, match_duration
            FROM tournaments
            WHERE id = :id AND user_id = :user_id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);

        return $stmt->fetch() ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE tournaments
            SET name = :name,
                format = :format,
                type = :type,
                status = :status,
                match_duration = :match_duration
            WHERE id = :id AND user_id = :user_id
        ");

        return $stmt->execute([
            'id' => $data['id'],
            'user_id' => $data['user_id'],
            'name' => trim($data['name']),
            'format' => $data['format'],
            'type' => $data['type'],
            'status' => $data['status'],
            'match_duration' => (int) $data['match_duration'],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete(int $id, int $userId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM tournaments
            WHERE id = :id AND user_id = :user_id
        ");

        return $stmt->execute([
            'id' => $id,
            'user_id' => $userId,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT BY USER
    |--------------------------------------------------------------------------
    */
    public function countByUser(int $userId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS total
            FROM tournaments
            WHERE user_id = :user_id
        ");

        $stmt->execute(['user_id' => $userId]);

        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | GET STANDINGS (🔥 VERSION FIX)
    |--------------------------------------------------------------------------
    */
    public function getStandings(int $tournamentId, int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                t.id,
                t.name,

                COUNT(CASE WHEN m.status = 'played' THEN 1 END) AS played,

                SUM(CASE 
                    WHEN (m.team1_id = t.id AND m.score1 > m.score2)
                      OR (m.team2_id = t.id AND m.score2 > m.score1)
                    THEN 1 ELSE 0
                END) AS wins,

                SUM(CASE 
                    WHEN m.score1 = m.score2
                     AND m.status = 'played'
                    THEN 1 ELSE 0
                END) AS draws,

                SUM(CASE 
                    WHEN (m.team1_id = t.id AND m.score1 < m.score2)
                      OR (m.team2_id = t.id AND m.score2 < m.score1)
                    THEN 1 ELSE 0
                END) AS losses,

                COALESCE(SUM(CASE 
                    WHEN m.team1_id = t.id THEN m.score1
                    WHEN m.team2_id = t.id THEN m.score2
                END), 0) AS goals_for,

                COALESCE(SUM(CASE 
                    WHEN m.team1_id = t.id THEN m.score2
                    WHEN m.team2_id = t.id THEN m.score1
                END), 0) AS goals_against,

                (
                    COALESCE(SUM(CASE 
                        WHEN m.team1_id = t.id THEN m.score1
                        WHEN m.team2_id = t.id THEN m.score2
                    END), 0)
                    -
                    COALESCE(SUM(CASE 
                        WHEN m.team1_id = t.id THEN m.score2
                        WHEN m.team2_id = t.id THEN m.score1
                    END), 0)
                ) AS goal_difference,

                SUM(CASE 
                    WHEN (m.team1_id = t.id AND m.score1 > m.score2)
                      OR (m.team2_id = t.id AND m.score2 > m.score1)
                    THEN 3
                    WHEN m.score1 = m.score2 AND m.status = 'played'
                    THEN 1
                    ELSE 0
                END) AS points

            FROM teams t
            JOIN tournaments tr ON tr.id = t.tournament_id
            LEFT JOIN matches m
                ON (m.team1_id = t.id OR m.team2_id = t.id)
               AND m.tournament_id = t.tournament_id

            WHERE t.tournament_id = :tournament_id
              AND tr.user_id = :user_id

            GROUP BY t.id
            ORDER BY points DESC, goal_difference DESC, goals_for DESC, t.name ASC
        ");

        $stmt->execute([
            'tournament_id' => $tournamentId,
            'user_id' => $userId,
        ]);

        return $stmt->fetchAll();
    }
}