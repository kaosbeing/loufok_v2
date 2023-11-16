<?php

class LoufokerieModel extends Model
{
    protected $tableName = APP_TABLE_PREFIX . 'loufokerie';
    protected $tableNameContribution = APP_TABLE_PREFIX . 'contribution';
    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Renvoie le cadavre en cours
     * @return array Le cadavre
     * @return null si aucun cadavre n'existe
     */
    public function findCurrent(): ?array
    {
        $today = date('y-m-d');
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_debut_loufokerie <= :today AND date_fin_loufokerie >= :today LIMIT 1;";
        $sth = $this->query($sql, [':today' => $today]);
        if ($sth && $sth->rowCount()) {
            return $sth->fetch();
        }

        return null;
    }

    public function findFuture(): ?array
    {
        $today = date('y-m-d');
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_debut_loufokerie >= :today";
        $sth = $this->query($sql, [':today' => $today]);
        if ($sth && $sth->rowCount()) {
            return $sth->fetchAll();
        }

        return null;

    }

    /**
     * Renvoie le dernier cadavre terminé
     * @return array Le cadavre
     * @return null si aucun cadavre n'existe
     */
    public function findOld($userId): ?array
    {
        $today = date('y-m-d');
        $sql = "SELECT *
        FROM `{$this->tableName}`
        WHERE id IN (
            SELECT id_loufokerie
            FROM `{$this->tableNameContribution}`
            WHERE id_joueur = :joueurId
        )
        AND date_fin_loufokerie < :today
        ORDER BY date_fin_loufokerie DESC
        LIMIT 1;";
        $sth = $this->query($sql, [':today' => $today, ':joueurId' => $userId]);
        if ($sth && $sth->rowCount()) {
            return $sth->fetch();
        }

        return null;
    }
}
