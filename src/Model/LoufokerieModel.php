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
     * @return array
     * @return null 
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
    /**
     * Renvoie tout les cadavres prévus et en cours
     * @return array 
     * @return null 
     */
    public function findFuture(): ?array
    {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_debut_loufokerie >= CURDATE()";
        $sth = $this->query($sql);
        if ($sth && $sth->rowCount()) {
            return $sth->fetchAll();
        }

        return null;

    }
      /**
     * Renvoie toute les périodes ou une cadavre est prévue
     * @return array 
     * @return null 
     */
    public function getPeriods(): ?array
    {
        $sql = "SELECT titre_loufokerie, date_debut_loufokerie, date_fin_loufokerie
        FROM `{$this->tableName}`
        WHERE date_fin_loufokerie >= CURDATE()
        ORDER BY date_debut_loufokerie";
        $sth = $this->query($sql);
        if ($sth && $sth->rowCount()) {
            return $sth->fetchAll();
        }

        return null;

    }

    /**
     * Renvoie le dernier cadavre terminé
     * @param int $userId id d'un joueur
     * @return array
     * @return null
     */
    public function findOld(int $userId): ?array
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
    /**
     * Renvoie le dernier cadavre terminé
     * @return array
     * @return null
     */
    public function findTitles(): ?array
    {
        $sql = "SELECT titre_loufokerie FROM `{$this->tableName}`";
        $sth = $this->query($sql);
        if ($sth && $sth->rowCount()) {
            return $sth->fetchAll();
        }
        return null;
    }
}
