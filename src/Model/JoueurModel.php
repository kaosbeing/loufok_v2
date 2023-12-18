<?php


class JoueurModel extends Model {
    protected $tableName = APP_TABLE_PREFIX . 'joueur';
    protected $tableNameContribution = APP_TABLE_PREFIX . 'contribution';
    protected static $instance;



    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    /**
     * Renvoie tout les joueurs par ordre alphabétique ayant participé a une loufokerie
     * @param int $id id de la loufokerie
     * @return array 
     * @return null
     */
    public function findOrdered(int $id): ?array {
        $sql = "SELECT *
        FROM `{$this->tableName}` j
        JOIN `{$this->tableNameContribution}` c ON j.id = c.id_joueur
        WHERE c.id_loufokerie = :id
        ORDER BY j.nom_plume ASC";
        $sth = $this->query($sql, [':id' => $id]);
        if ($sth && $sth->rowCount()) {
            return $sth->fetchAll();
        }

        return null;
    }

    /**
     * Renvoie tout les joueurs par ordre alphabétique ayant participé a une loufokerie
     * @param int $id id de la loufokerie
     * @return array 
     * @return null
     */
    public function findNameOrdered(int $id): ?array {
        $sql = "SELECT nom_plume
        FROM `{$this->tableName}` j
        JOIN `{$this->tableNameContribution}` c ON j.id = c.id_joueur
        WHERE c.id_loufokerie = :id
        ORDER BY j.nom_plume ASC";
        $sth = $this->query($sql, [':id' => $id]);
        if ($sth && $sth->rowCount()) {
            return $sth->fetchAll();
        }

        return null;
    }

    /**
     * Récupère tous les noms de joueurs d'une loufokerie
     * 
     * @param int $id id de la loufokerie
     * @return array de tous les noms de plume, null si aucun
     */
    public function GetAllNamesFromLoufokerie(int $id): array {
        $usernames = [];
        $contribs = ContributionModel::getInstance()->findBy(["id_loufokerie" => $id]);

        if ($contribs) {
            foreach ($contribs as $contrib) {
                if ($contrib['id_joueur'] != null) {
                    $users[] = JoueurModel::getInstance()->find($contrib["id_joueur"]);
                }
            }
        }

        if (isset($users)) {
            foreach ($users as $user) {
                $usernames[] = $user["nom_plume"];
            }
        }

        return $usernames;
    }
    /**
     * Retourne un joueur si il a reservé la contribution aujourd'hui
     *
     * @return array
     */
    public function findReserved(): ?array {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE reservation = CURDATE()";
        $sth = $this->query($sql);
        if ($sth && $sth->rowCount()) {
            return $sth->fetch();
        }

        return null;
    }
}
