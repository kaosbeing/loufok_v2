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
     * Retrieves all names from all contribs from a Loufok
     * 
     * @param int $id id of the loufokerie
     * @return array of all usernames, empty array if no usernames
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
}
