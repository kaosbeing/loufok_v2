<?php

class UserController
{
    public static function userIndexPage(?string $error = null)
    {
        $user = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_COOKIE['email']])[0];
        $currentLoufokerie = LoufokerieModel::getInstance()->findCurrent();
        $nb_contribution = $currentLoufokerie ? ContributionModel::getInstance()->getSubmissionNumber($currentLoufokerie['id']) : null;
        $random_contribution = $currentLoufokerie ? RandomModel::getInstance()->getRandomSubmission($user["id"], $currentLoufokerie['id']) : null;
        $oldLoufokerie = LoufokerieModel::getInstance()->findOld($user['id']);
        $old_contribution = $oldLoufokerie ? ContributionModel::getInstance()->findBy(['id_joueur' => $user['id'], 'id_loufokerie' => $oldLoufokerie['id']])[0] : null;

        userIndexPage::render([
            "error" => $error,
            "currentLoufokerie" => $currentLoufokerie,
            "nb_contribution" => $nb_contribution,
            "random_contribution" => $random_contribution,
            "oldLoufokerie" => $oldLoufokerie,
            "old_contribution" => $old_contribution,
            "user" => $user,
        ]);
    }

    public static function userLoufokeriePage()
    {
        $user = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_COOKIE['email']])[0];
        $loufokerie = LoufokerieModel::getInstance()->findCurrent();

        $random_contribution = $loufokerie ? RandomModel::getInstance()->getRandomSubmission($user["id"], $loufokerie['id']) : null;
        if (!$random_contribution)
        {
            RandomModel::getInstance()->assignRandomSubmission($user['id'], $loufokerie['id']);
        }

        $contributionArray = ContributionModel::getInstance()->getArrayFullOfEmptyStringsExceptRandomAndOwnSubmission($user["id"], $loufokerie["id"]);

        userLoufokeriePage::render([
            "loufokerie" => $loufokerie,
            "contributionArray" => $contributionArray,
            "contributed" => UserController::hasContributedTo($loufokerie),
        ]);
    }
    public static function userSubmission()
    {
        $today = date_create(date('y-m-d'));
        $loufokerie = LoufokerieModel::getInstance()->findCurrent();
        $user = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_COOKIE['email']])[0];
        $contributions = ContributionModel::getInstance()->findByOrdered(['id_loufokerie' => $loufokerie['id']]);
        $contributionArray = ContributionModel::getInstance()->getArrayFullOfEmptyStringsExceptRandomAndOwnSubmission($user["id"], $loufokerie["id"]);

        $errors = [];
        if (date_create($loufokerie['date_debut_loufokerie']) > $today)
        {
            $errors[] = "C'est encore trop tôt ! Attendez le début de la Loufokerie";
        }
        if (UserController::hasContributedTo($loufokerie))
        {
            $errors[] = "Vous avez déjà contribué !";
        }
        if (date_create($loufokerie['date_fin_loufokerie']) < $today)
        {
            $errors[] = "Trop tard ! La Loufokerie est finit...";
        }
        if (count($contributions) >= $loufokerie['nb_contributions'])
        {
            $errors[] = "Trop tard... Les autres ont déjà complété la loufokerie !";
        }
        if (strlen($_POST['texte']) > 280)
        {
            $errors[] = "Votre contribution est trop longue !";
        }
        if (strlen($_POST['texte']) < 50)
        {
            $errors[] = "Votre contribution est trop courte !";
        }
        if (empty($errors))
        {
            ContributionModel::getInstance()->create([
                'id_joueur' => $user['id'],
                'texte' => $_POST['texte'],
                'id_loufokerie' => $loufokerie['id'],
                'ordre_soumission' => count($contributions) + 1,
                'date_soumission' => date('y-m-d'),
            ]);
        }

        $datas = [
            "loufokerie" => $loufokerie,
            "contributionArray" => $contributionArray,
            "contributed" => UserController::hasContributedTo($loufokerie),
            "errors" => $errors
        ];

        userLoufokeriePage::render($datas);
    }

    public static function userHistoriquePage()
    {
        userHistoriquePage::render();
    }

    public static function hasContributedTo($loufokerie): ?bool
    {
        $user = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_COOKIE['email']])[0];
        $hasContributed = ContributionModel::getInstance()->findBy(['id_joueur' => $user['id'], 'id_loufokerie' => $loufokerie['id']]) ? true : false;
        return $hasContributed;
    }
}
