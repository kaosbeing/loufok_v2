<?php

class Loufokerie extends Model
{
    protected $tableName = APP_TABLE_PREFIX.'loufokerie';
    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function findCurrent(): ?array
    {
        $today = date('y-m-d');
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_debut_loufokerie <= '$today' AND date_fin_loufokerie >= '$today'";

        return $this->query($sql)->fetchAll();
    }

    public function findOld(): ?array
    {
        $today = date('y-m-d');
        $sql = "SELECT * FROM `{$this->tableName}` WHERE date_fin_loufokerie < '$today'";

        return $this->query($sql)->fetchAll();
    }
}
