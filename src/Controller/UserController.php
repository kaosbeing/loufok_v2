<?php

class UserController
{
    public static function userIndexPage(?string $error = null)
    {
        $user = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_COOKIE['email']])[0];
        $currentLoufokerie = LoufokerieModel::getInstance()->findCurrent();
        $nb_contribution = $currentLoufokerie ? ContributionModel::getInstance()->getSubmissionNumber($currentLoufokerie['id']) : null;
        $random_contribution = $currentLoufokerie ? RandomModel::getInstance()->getRandomSubmission($user["id"], $currentLoufokerie['id']) : null;
        $oldLoufokerie = LoufokerieModel::getInstance()->findOld();

        userIndexPage::render([
            "error" => $error,
            "currentLoufokerie" => $currentLoufokerie,
            "nb_contribution" => $nb_contribution,
            "random_contribution" => $random_contribution,
            "oldLoufokerie" => $oldLoufokerie,
        ]);
    }

    public static function userLoufokeriePage()
    {
        $user = JoueurModel::getInstance()->findBy(['ad_mail_joueur' => $_COOKIE['email']])[0];
        $currentLoufokerie = LoufokerieModel::getInstance()->findCurrent();

        $random_contribution = $currentLoufokerie ? RandomModel::getInstance()->getRandomSubmission($user["id"], $currentLoufokerie['id']) : null;
        if (!$random_contribution)
        {
            RandomModel::getInstance()->assignRandomSubmission($user['id'], $currentLoufokerie['id']);
        }

        $contributionArray = ContributionModel::getInstance()->getArrayFullOfEmptyStringsExceptRandomAndOwnSubmission($user["id"], $currentLoufokerie["id"]);

        userLoufokeriePage::render([
            "loufokerie" => $currentLoufokerie,
            "contributionArray" => $contributionArray,
        ]);
    }

    public static function userHistoriquePage()
    {
        userHistoriquePage::render();
    }
}
