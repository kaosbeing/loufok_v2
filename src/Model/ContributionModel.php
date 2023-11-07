<?php

class ContributionModel extends Model
{
    protected $tableName = APP_TABLE_PREFIX.'contribution';
    protected static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public function findByOrdered(array $criterias): ?array
    {
        // décomposer le tableau des critères
        foreach ($criterias as $f => $v) {
            $fields[] = "$f = ?";
            $values[] = $v;
        }
        // On transforme le tableau en chaîne de caractères séparée par des AND
        $fields_list = implode(' AND ', $fields);
        $sql = "SELECT * FROM `{$this->tableName}` WHERE $fields_list ORDER BY ordre_soumission ASC";

        return $this->query($sql, $values)->fetchAll();
    }

    public function getArrayFullOfEmptyStringsExceptRandomAndOwnSubmission(int $id_joueur, int $id_loufokerie): ?array
    {
        $emptied = [];
        $contributions = Contribution::getInstance()->findByOrdered(['id_loufokerie' => $id_loufokerie]);
        $random = Random::getInstance()->findBy(['id_joueur' => $id_joueur, 'id_cadavre' => $id_loufokerie])[0];
        $joueur_contribution = Contribution::getInstance()->findBy(['id_joueur' =>$id_joueur, 'id_cadavre' => $id_loufokerie])[0];
        foreach ($contributions as $contribution) {
            if ($contribution['id'] == $random['id']) {
                array_push($emptied, $contribution);
            }
            else if ($contribution['id'] == $joueur_contribution['id']) {
                array_push($emptied, $contribution);
            } else{
               array_push($emptied, '');
            }
        }
        return $emptied;
    }
}
