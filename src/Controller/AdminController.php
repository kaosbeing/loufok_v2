<?php

class AdminController
{

    public static function adminIndexPage()
    {
        adminIndexPage::render();
    }
    public static function adminNouveauPage()
    {
        adminNouveauPage::render();
    }
    public static function NewLoufokerie()
    {
        if(AdminController::IsPeriodAvailable($_POST['date-debut'], $_POST['date-fin'])){
            $user = AdministrateurModel::getInstance()->findBy(['ad_mail_administrateur' => $_COOKIE['email']])[0];
            $cadavre = LoufokerieModel::getInstance()->create([
                'id_administrateur' => $user['id'],
                'titre_cadavre' => $_POST['titre'],
                'date_debut_cadavre' => date('y-m-d', strtotime($_POST['date-debut'])),
                'date_fin_cadavre' => date('y-m-d', strtotime($_POST['date-fin'])),
                'nb_contributions' => $_POST['nb_contributions'],
            ]);
            $contribution = LoufokerieModel::getInstance()->create([
                'id_administrateur' => $user['id'],
                'texte' => $_POST['texte'],
                'id_cadavre' => $cadavre,
                'ordre_soumission' => 1,
                'date_soumission' => date('y-m-d'),
            ]);
            HTTP::redirect('/admin');
        }
        $error = "Période invalide";
        adminNouveauPage::render([$error]);
       
        
    }
    public static function IsPeriodAvailable($debut, $fin): ?bool
    {
        $valid_date = true;
        $loufokeries = LoufokerieModel::getInstance()->findFuture();
        foreach ($loufokeries as $loufokerie) {
            if($debut >= $loufokerie['date_debut_cadavre'] && $debut <= $loufokerie['date_fin_cadavre']){
                $valid_date = false;
            }
            if($fin >= $loufokerie['date_debut_cadavre'] && $fin <= $loufokerie['date_fin_cadavre']){
                $valid_date = false;
            }
        }
        return $valid_date;
    }
}
