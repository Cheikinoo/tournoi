<?php

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /*
    |--------------------------------------------------------------------------
    | FETCH ALL (helper)
    |--------------------------------------------------------------------------
    */
    protected function fetchAll(PDOStatement $stmt): array
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /*
    |--------------------------------------------------------------------------
    | FETCH ONE (helper)
    |--------------------------------------------------------------------------
    */
    protected function fetch(PDOStatement $stmt): ?array
    {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /*
    |--------------------------------------------------------------------------
    | EXECUTE SAFE
    |--------------------------------------------------------------------------
    */
    protected function execute(PDOStatement $stmt, array $params = []): bool
    {
        try {
            return $stmt->execute($params);
        } catch (PDOException $e) {

            if (defined('APP_DEBUG') && APP_DEBUG) {
                echo "<pre>";
                echo "SQL Error: " . $e->getMessage();
                echo "</pre>";
            }

            return false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LAST INSERT ID
    |--------------------------------------------------------------------------
    */
    protected function lastInsertId(): int
    {
        return (int) $this->db->lastInsertId();
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSACTION (🔥 PRO)
    |--------------------------------------------------------------------------
    */
    protected function beginTransaction(): void
    {
        $this->db->beginTransaction();
    }

    protected function commit(): void
    {
        $this->db->commit();
    }

    protected function rollback(): void
    {
        if ($this->db->inTransaction()) {
            $this->db->rollBack();
        }
    }
}