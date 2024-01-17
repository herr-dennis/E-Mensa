<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/db_handling.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/Bewertungen.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/Gerichte.php');
class BewertungController{

    public function bewertungen(){
        /**
         * Wenn nicht angemeldet, zur Anmeldung
         */

        if(!isset($_SESSION['login'])){
            header("Location: anmeldung");
            $_SESSION["comeFrom"]='bewertung';
            exit();
        }
        $id = $_SESSION['id'];
        $admin = false;
        $auswahl=false;
        $userData= array();
        if(isAdmin($id)){
           $admin=true;
            echo "Du bist Admin!";
        }
        /**
         * Wenn Get_Parameter gesetzt ist.
         */
        if(isset($_GET['id'])){
            $auswahl = true;
            $idGet= $_GET['id'];
            $userData =    take_data_for_user_rating($idGet);
            unset($_GET['id']);
            foreach ($userData as $key => $item) {
                if ($userData[$key]['bildname'] == NULL) {
                    $userData[$key]['bildname'] = "/emensa/public/img/gerichte/00_image_missing.jpg";
                } else {
                    $userData[$key]['bildname'] = "/emensa/public/img/gerichte/" . $item['bildname'];
                }
            }
        }

        if(isset($_GET['glowUP'])){
            $ratingID = $_GET['glowUP'];
            unset($_GET['glowUP']);
            setHighlightRating($ratingID);

        }


        /**
         * Einfügen neuer Bewertungen
         */
        if(isset($_POST['nameBewertung'])){
            $gerichtsID = take_mealID_by_name($_POST['nameBewertung']);
            echo $id;
            setRating((int)$id,$gerichtsID['id'], $_POST['textBewertung'], (int)$_POST['sterneBewertung']);
            unset($_GET['id']);
            $auswahl=false;
        }

             $data = take_data_for_ratings($id);


        /**
         * Aufbereitung der Bilder
         */
        foreach ($data as $key => $item) {
            if ($data[$key]['bildname'] == NULL) {
                $data[$key]['bildname'] = "/emensa/public/img/gerichte/00_image_missing.jpg";
            } else {
                $data[$key]['bildname'] = "/emensa/public/img/gerichte/" . $item['bildname'];
            }
        }

        return view('examples.pages.bewertungen', ['data'=> $data ,'userData'=>$userData
                              ,"auswahl"=>$auswahl , 'admin'=>$admin] );
    }

    public  function meineBewertung (){

        if(!isset($_SESSION['login'])){
            header("Location: anmeldung");
            $_SESSION["comeFrom"]='meineBewertung';
            exit();
        }

        if(isset($_GET['name'])){

            $name = urldecode($_GET['name']);
            unset($_GET['name']);
            $Bewertung = new Bewertungen();
            $bewertung = $Bewertung::query()->where('bewertungszeitpunkt',$name);
            $bewertung->delete();


        }
        $id = $_SESSION['id'];
        $data = take_rating_for_user($id);

        /**
         * Aufbereitung der Bilder
         */
        foreach ($data as $key => $item) {
            if ($data[$key]['bildname'] == NULL) {
                $data[$key]['bildname'] = "/emensa/public/img/gerichte/00_image_missing.jpg";
            } else {
                $data[$key]['bildname'] = "/emensa/public/img/gerichte/" . $item['bildname'];
            }
        }

        return view('examples.pages.meineBewertungPage' , ['data' =>$data]);
    }

}