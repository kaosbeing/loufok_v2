<?php

class LoufokerieModel extends Model
{
    protected $tableName = APP_TABLE_PREFIX . 'loufokerie';
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
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_debut_loufokerie <= '$today' AND date_fin_loufokerie >= '$today'";

        return $this->query($sql)->fetch() ? $this->query($sql)->fetch() : null;
    }

    /**
     * Renvoie le dernier cadavre terminé
     * @return array Le cadavre
     * @return null si aucun cadavre n'existe
     */
    public function findOld(): ?array
    {
        $today = date('y-m-d');
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_fin_loufokerie < '$today' ORDER BY date_fin_loufokerie DESC";

        return $this->query($sql)->fetch() ? $this->query($sql)->fetch() : null;
    }
}
