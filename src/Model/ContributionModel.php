<?php

class ContributionModel extends Model {
    protected $tableName = APP_TABLE_PREFIX . 'contribution';
    protected static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Renvoit toute les contributions par ordre de soumission pour des critères précisés
     * @param array $criterias le tableau des critères
     * @return array
     */
    public function findByOrdered(array $criterias): ?array {
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


    /**
     * Renvoit un array de remplit de strings vides sauf la contribution random et sa propre contribution
     * @param int $id_joueur
     * @param int $id_loufokerie
     * @return array
     */
    public function getArrayFullOfEmptyStringsExceptRandomAndOwnSubmission(int $id_joueur, int $id_loufokerie): ?array {
        $emptied = [];
        $contributions = ContributionModel::getInstance()->findByOrdered(['id_loufokerie' => $id_loufokerie]);
        $random = RandomModel::getInstance()->findBy(['id_joueur' => $id_joueur, 'id_loufokerie' => $id_loufokerie]) ?  RandomModel::getInstance()->findBy(['id_joueur' => $id_joueur, 'id_loufokerie' => $id_loufokerie])[0] : null;
        $joueur_contribution = ContributionModel::getInstance()->findBy(['id_joueur' => $id_joueur, 'id_loufokerie' => $id_loufokerie]) ? ContributionModel::getInstance()->findBy(['id_joueur' => $id_joueur, 'id_loufokerie' => $id_loufokerie])[0] : null;
  
        foreach ($contributions as $contribution) {
            if (isset($random) && $contribution['id'] == $random['id_contribution']) {
                array_push($emptied, $contribution['texte']);
             
            } else if (isset($joueur_contribution['id']) && $contribution['id'] == $joueur_contribution['id']) {
                array_push($emptied, $contribution['texte']);
            } else {
                array_push($emptied, '');
            }
        }
        return $emptied;
    }


    /**
     * Renvoit un array de remplit de strings vides sauf la contribution random et sa propre contribution
     * @param int $id_joueur
     * @param int $id_loufokerie
     * @return int
     */
    public function getSubmissionNumber(int $id_loufok): ?int {
        $sql = "SELECT COUNT(*) as nb_contrib FROM `{$this->tableName}` WHERE id_loufokerie = :id_loufokerie";

        return $this->query($sql, [':id_loufokerie' => $id_loufok])->fetch() ? $this->query($sql, [':id_loufokerie' => $id_loufok])->fetch()["nb_contrib"] : null;
    }

    /**
     * 
     */
    public function getArrayFullOfEmptyStringsExceptItsNotEmpty(int $id_loufokerie): ?array {
        $texts = [];
        $contributions = ContributionModel::getInstance()->findByOrdered(['id_loufokerie' => $id_loufokerie]);

        foreach ($contributions as $contribution) {
            array_push($texts, $contribution['texte']);
        }

        return $texts;
    }
}
