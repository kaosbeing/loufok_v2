<?php


class JoueurModel extends Model
{
    protected $tableName = APP_TABLE_PREFIX . 'joueur';
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
     * Renvoie tout les joueurs par ordre alphabétique ayant participé a une loufokerie
     * @param int $id id de la loufokerie
     * @return array 
     * @return null
     */
    public function findOrdered(int $id): ?array
    {
        $sql = "SELECT *
        FROM `{$this->tableName}` j
        JOIN `{$this->tableNameContribution}` c ON j.id = c.id_joueur
        WHERE c.id_loufokerie = :id
        ORDER BY j.nom_plume ASC";
        $sth = $this->query($sql, [':id' => $id]);
        if ($sth && $sth->rowCount())
        {
            return $sth->fetchAll();
        }

        return null;
    }
}
