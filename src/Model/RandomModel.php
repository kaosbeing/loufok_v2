<?php

class RandomModel extends Model
{
    protected $tableName = APP_TABLE_PREFIX . 'random';
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
     * Renvoit la contribution random d'un user pour une loufokerie
     * 
     * @param int $id_user id d'un joueur
     * @param int $id_loufokerie id d'une loufokerie 
     * @return array
     */
    public function getRandomSubmission(int $id_user, int $id_loufokerie): ?array
    {
        $sql = "SELECT id_contribution FROM `{$this->tableName}` WHERE id_joueur = '$id_user' AND id_loufokerie = :id_loufokerie";
        $id_contrib = $this->query($sql, [':id_loufokerie' => $id_loufokerie])->fetch() ? $this->query($sql, [':id_loufokerie' => $id_loufokerie])->fetch()["id_contribution"] : null;
        $contrib = null;
        if ($id_contrib)
        {
            $contrib = ContributionModel::getInstance()->find($id_contrib);
        }

        return $contrib;
    }

    /**
     * Créez une contribution random d'un user pour une loufokerie
     * 
     * @param int $id_user id d'un joueur
     * @param int $id_loufokerie id d'une loufokerie
     */
    public function assignRandomSubmission(int $id_user, int $id_loufokerie)
    {
        $nbcontrib = count(ContributionModel::getInstance()->findBy(['id_loufokerie' => $id_loufokerie]));
        $rand = rand(1, $nbcontrib);
        $randomContrib = ContributionModel::getInstance()->findBy([
            'id_loufokerie' => $id_loufokerie,
            'ordre_soumission' => $rand
        ])[0];

        RandomModel::getInstance()->create([
            'id_joueur' => $id_user,
            'id_loufokerie' => $id_loufokerie,
            'id_contribution' => $randomContrib['id']
        ]);
    }
}
