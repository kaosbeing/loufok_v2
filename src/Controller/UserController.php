<?php

class UserController
{
    public static function userIndexPage()
    {
        $currentLoufokerie = LoufokerieModel::getInstance()->findCurrent();
        $oldLoufokerie = LoufokerieModel::getInstance()->findOld();

        userIndexPage::render([
            "currentLoufokerie" => $currentLoufokerie,
            "oldLoufokerie" => $oldLoufokerie,
        ]);
    }

    public static function userParticipationPage()
    {
        userIndexPage::render();
    }

    public static function userHistoriquePage()
    {
        userHistoriquePage::render();
    }
}
