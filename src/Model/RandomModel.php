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
     * Return the random submission of a user for a loufokerie
     * 
     * @param int $id_user id of the user
     * @param int $id_loufokerie id of the loufokerie
     * @return array The submission of the user
     */
    public function getRandomSubmission(int $id_user, int $id_loufokerie): ?array
    {
        $sql = "SELECT id_contribution FROM `{$this->tableName}` WHERE id_joueur = '$id_user' AND id_loufokerie = '$id_loufokerie'";
        $id_contrib = $this->query($sql)->fetch() ? $this->query($sql)->fetch()["id_contribution"] : null;
        $contrib = null;
        if ($id_contrib)
        {
            $contrib = ContributionModel::getInstance()->find($id_contrib);
        }

        return $contrib;
    }

    /**
     * Create a random_contribution object with a random id_contribution
     * 
     * @param int $id_user ID of the user
     * @param int $id_loufokerie ID of the loufokerie
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
