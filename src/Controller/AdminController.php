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
        $errors = [];
        $periode_available = AdminController::IsPeriodAvailable($_POST['date-debut'], $_POST['date-fin']);
        if(!AdminController::IsPeriodLogic($_POST['date-debut'], $_POST['date-fin'])){
            $errors[] = `La date est érroné. La période débute après sa fin.`;
        }
        if(!$periode_available[0]){
           
            $errors[] = `Une Loufokerie est déjà prévue du {$periode_available[1]} au {$periode_available[2]}.`;
        }
        if(!AdminController::IsTitreAvailable($_POST['titre'])){
          
            $errors[] = `Ce titre est déjà utilisé.`;
        }
        if($_POST['nb_contributions'] < 2){
          
            $errors[] = `Il y a trop peu de contributions.`;
        }
        if(empty($errors)){
          
            $user = AdministrateurModel::getInstance()->findBy(['ad_mail_administrateur' => $_COOKIE['email']])[0];
            $loufokerie = LoufokerieModel::getInstance()->create([
                'id_administrateur' => $user['id'],
                'titre_loufokerie' => $_POST['titre'],
                'date_debut_loufokerie' => date('y-m-d', strtotime($_POST['date-debut'])),
                'date_fin_loufokerie' => date('y-m-d', strtotime($_POST['date-fin'])),
                'nb_contributions' => $_POST['nb_contributions'],
            ]);
            ContributionModel::getInstance()->create([
                'id_administrateur' => $user['id'],
                'texte' => $_POST['texte'],
                'id_loufokerie' => $loufokerie,
                'ordre_soumission' => 1,
                'date_soumission' => date('y-m-d'),
            ]);
            HTTP::redirect('/admin');
        }
      
        adminNouveauPage::render([$errors]);
    }
    public static function IsPeriodAvailable($debut, $fin): ?array
    {
        $valid_date = true;
        $date_debut = null;
        $date_fin = null;
        $loufokeries = LoufokerieModel::getInstance()->findFuture();
        if(!empty($loufokeries)){
            foreach ($loufokeries as $loufokerie) {
                if($debut >= $loufokerie['date_debut_loufokerie'] && $debut <= $loufokerie['date_fin_loufokerie']){
                    $valid_date = false;
                }
                if($fin >= $loufokerie['date_debut_loufokerie'] && $fin <= $loufokerie['date_fin_loufokerie']){
                    $valid_date = false;
                }
            }
        }
        return [$valid_date, $date_debut, $date_fin];
    }public static function IsPeriodLogic($debut, $fin): ?bool
    {
        $valid_date = true;
        if($debut < $fin){
            $valid_date = false;
        }
        return $valid_date;
    }
    public static function IsTitreAvailable($titre): ?bool
    {
        $valid_titre = true;
        $loufokeries = LoufokerieModel::getInstance()->findAll();
        if(!empty($loufokeries)){
            foreach ($loufokeries as $loufokerie) {
                if($titre == $loufokerie['titre_loufokerie']){
                    $valid_titre = false;
                }
              
            }
        }
        return $valid_titre;
    }
}
