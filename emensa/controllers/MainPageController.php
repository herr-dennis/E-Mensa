<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/db_handling.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/take_img.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/Gerichte.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/Bewertungen.php');
class MainPageController
{

    public  function mainPageController(){
        /**
         * Hier wird das ORM benutzt!
         */
        $gerichte = new Gerichte();
        $data = $gerichte::query()->get();

        if(isset($_SESSION['login'])){
            if($_SESSION['login']===true){
                $log = logger('info');
                $log->info("Benutzer ".$_SESSION['name']." ruft Hauptseite auf");
            }

        } else{
            $log = logger('info');
            $log->info("Anonymer Benutzer ruft Hauptseite auf mit:".$_SERVER['REMOTE_ADDR']);
        }


        $BewertungObjekt = new Bewertungen();
        $mealsRating = $BewertungObjekt::query()->join('gericht', 'gericht.id', '=', 'bewertungen.gerichtsID')
            ->where('bewertungen.highlightRating', '=', 1)
            ->get();

        //$mealsRating = take_rating_meals();

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

        return view('examples.pages.mainPage', ['data' => $data , 'mealsRating'=>$mealsRating]  );

    }

}