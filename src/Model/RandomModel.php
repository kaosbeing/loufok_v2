<?php

class RandomModel extends Model
{
    protected $tableName = APP_TABLE_PREFIX.'random';
    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
