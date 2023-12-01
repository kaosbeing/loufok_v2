<?php

class LoufokerieModel extends Model {
    protected $tableName = APP_TABLE_PREFIX . 'loufokerie';
    protected $tableNameContribution = APP_TABLE_PREFIX . 'contribution';
    protected static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Renvoie la loufokerie en cours
     * @return array
     * @return null 
     */
    public function findCurrent(): ?array {
        $today = date('Y-m-d');
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_debut_loufokerie <= :today AND date_fin_loufokerie >= :today LIMIT 1;";
        $sth = $this->query($sql, [':today' => $today]);
        if ($sth && $sth->rowCount()) {
            return $sth->fetch();
        }

        return null;
    }
    /**
     * Renvoie toutes les loufokeries prévus et en cours
     * @return array 
     * @return null 
     */
    public function findFuture(): ?array {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_debut_loufokerie >= CURDATE()";
        $sth = $this->query($sql);
        if ($sth && $sth->rowCount()) {
            return $sth->fetchAll();
        }

        return null;
    }
    /**
     * Renvoie toute les périodes ou des loufokeries sont prévues
     * @return array 
     * @return null 
     */
    public function getPeriods(): ?array {
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
     * Renvoie la dernière loufokerie terminé
     * @param int $userId id d'un joueur
     * @return array Liste des anciennes loufokeries
     * @return null Si aucun
     */
    public function findOld(int $userId): ?array {
        $today = date('Y-m-d');
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
     * Renvoie la liste de tous les titres des loufokeries
     * @return array 
     * @return null
     */
    public function findTitles(): ?array {
        $sql = "SELECT titre_loufokerie FROM `{$this->tableName}`";
        $sth = $this->query($sql);
        if ($sth && $sth->rowCount()) {
            return $sth->fetchAll();
        }
        return null;
    }

    /**
     * Vérifie si la loufokerie existe dans la base de donnée
     * @param int $id L'ID d'une Loufokerie
     * @return true si la loufokerie existe, false sinon
     */
    public function exists(int $id): bool {
        if (LoufokerieModel::getInstance()->find($id)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Renvoie le nombre de likes d'une loufokerie
     * @param int $id L'ID d'une loufokerie
     * @return int Nombre de likes
     */
    public function getLikes(int $id): ?int {
        $sql = "SELECT nb_jaime FROM `{$this->tableName}` WHERE id = :id";
        $sth = $this->query($sql, [':id' => $id]);
        if ($sth && $sth->rowCount()) {
            $nb_jaime = $sth->fetch()["nb_jaime"];
            return $nb_jaime;
        }

        return null;
    }
}
