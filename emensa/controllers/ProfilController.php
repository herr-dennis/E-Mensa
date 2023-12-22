<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/db_handling.php');

class ProfilController{


    public function profil(){

        if($_SESSION['login']===true){
            $daten = get_all_user($_SESSION['id']);
            return view('examples.pages.profil', ['daten' => $daten]);
        }else{
            header('Location:/emensa/public/anmeldung');
        }



}

}
