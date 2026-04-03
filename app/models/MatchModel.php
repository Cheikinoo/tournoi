<?php

class MatchModel extends Model
{
    /*
    |--------------------------------------------------------------------------
    | GET MATCHES BY TOURNAMENT (🔥 AVEC LOGOS)
    |--------------------------------------------------------------------------
    */
    public function getByTournament(int $tournamentId, int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT m.*,
                   t1.name AS team1_name,
                   t1.logo AS team1_logo,
                   t2.name AS team2_name,
                   t2.logo AS team2_logo
            FROM matches m
            INNER JOIN tournaments tr ON m.tournament_id = tr.id
            INNER JOIN teams t1 ON m.team1_id = t1.id
            INNER JOIN teams t2 ON m.team2_id = t2.id
            WHERE m.tournament_id = :tournament_id
              AND tr.user_id = :user_id
            ORDER BY m.match_time ASC, m.id ASC
        ");

        $stmt->execute([
            'tournament_id' => $tournamentId,
            'user_id' => $userId,
        ]);

        return $stmt->fetchAll() ?: [];
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE MATCH (🔥 AVEC HEURE)
    |--------------------------------------------------------------------------
    */
    public function create(array $data): bool
    {
        if (
            empty($data['tournament_id']) ||
            empty($data['team1_id']) ||
            empty($data['team2_id'])
        ) {
            return false;
        }

        if ($data['team1_id'] === $data['team2_id']) {
            return false;
        }

        $stmt = $this->db->prepare("
            INSERT INTO matches (
                tournament_id,
                team1_id,
                team2_id,
                score1,
                score2,
                status,
                match_time
            )
            VALUES (
                :tournament_id,
                :team1_id,
                :team2_id,
                NULL,
                NULL,
                'scheduled',
                :match_time
            )
        ");

        return $stmt->execute([
            'tournament_id' => $data['tournament_id'],
            'team1_id' => $data['team1_id'],
            'team2_id' => $data['team2_id'],
            'match_time' => $data['match_time'] ?? null
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR MATCHES
    |--------------------------------------------------------------------------
    */
    public function clearByTournament(int $tournamentId, int $userId): bool
    {
        $stmt = $this->db->prepare("
            DELETE m
            FROM matches m
            INNER JOIN tournaments tr ON m.tournament_id = tr.id
            WHERE m.tournament_id = :tournament_id
              AND tr.user_id = :user_id
        ");

        return $stmt->execute([
            'tournament_id' => $tournamentId,
            'user_id' => $userId
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FIND MATCH (🔥 AVEC LOGOS)
    |--------------------------------------------------------------------------
    */
    public function find(int $id, int $userId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT m.*,
                   t1.name AS team1_name,
                   t1.logo AS team1_logo,
                   t2.name AS team2_name,
                   t2.logo AS team2_logo
            FROM matches m
            INNER JOIN tournaments tr ON m.tournament_id = tr.id
            INNER JOIN teams t1 ON m.team1_id = t1.id
            INNER JOIN teams t2 ON m.team2_id = t2.id
            WHERE m.id = :id
              AND tr.user_id = :user_id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $id,
            'user_id' => $userId
        ]);

        return $stmt->fetch() ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE SCORE (🔥 CLEAN)
    |--------------------------------------------------------------------------
    */
    public function updateScore(int $id, int $userId, int $score1, int $score2): bool
    {
        if ($score1 < 0 || $score2 < 0) {
            return false;
        }

        $stmt = $this->db->prepare("
            UPDATE matches m
            INNER JOIN tournaments tr ON m.tournament_id = tr.id
            SET m.score1 = :score1,
                m.score2 = :score2,
                m.status = 'finished'
            WHERE m.id = :id
              AND tr.user_id = :user_id
        ");

        return $stmt->execute([
            'score1' => $score1,
            'score2' => $score2,
            'id' => $id,
            'user_id' => $userId
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RESET MATCH
    |--------------------------------------------------------------------------
    */
    public function resetScore(int $id, int $userId): bool
    {
        $stmt = $this->db->prepare("
            UPDATE matches m
            INNER JOIN tournaments tr ON m.tournament_id = tr.id
            SET m.score1 = NULL,
                m.score2 = NULL,
                m.status = 'scheduled'
            WHERE m.id = :id
              AND tr.user_id = :user_id
        ");

        return $stmt->execute([
            'id' => $id,
            'user_id' => $userId
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT MATCHES
    |--------------------------------------------------------------------------
    */
    public function countByUser(int $userId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM matches m
            INNER JOIN tournaments tr ON m.tournament_id = tr.id
            WHERE tr.user_id = :user_id
        ");

        $stmt->execute([
            'user_id' => $userId
        ]);

        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | COUNT FINISHED MATCHES
    |--------------------------------------------------------------------------
    */
    public function countPlayedByUser(int $userId): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM matches m
            INNER JOIN tournaments tr ON m.tournament_id = tr.id
            WHERE tr.user_id = :user_id
              AND m.status = 'finished'
        ");

        $stmt->execute([
            'user_id' => $userId
        ]);

        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    /*
    |--------------------------------------------------------------------------
    | RECENT MATCHES (🔥 AVEC LOGOS)
    |--------------------------------------------------------------------------
    */
    public function getRecentByUser(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT m.*,
                   t1.name AS team1_name,
                   t1.logo AS team1_logo,
                   t2.name AS team2_name,
                   t2.logo AS team2_logo
            FROM matches m
            INNER JOIN tournaments tr ON m.tournament_id = tr.id
            INNER JOIN teams t1 ON m.team1_id = t1.id
            INNER JOIN teams t2 ON m.team2_id = t2.id
            WHERE tr.user_id = :user_id
              AND m.status = 'finished'
            ORDER BY m.id DESC
            LIMIT 5
        ");

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll() ?: [];
    }
}