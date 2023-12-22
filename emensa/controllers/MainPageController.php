<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/db_handling.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/take_img.php');

class MainPageController
{

    public  function mainPageController(){

        $data = take_meals();
        $bilder = take_img(count($data)+7);

        if(isset($_SESSION['login'])){
            if($_SESSION['login']===true){
                $log = logger('info');
                $log->info("Benutzer ".$_SESSION['name']." ruft Hauptseite auf");
            }

        } else{
            $log = logger('info');
            $log->info("Anonymer Benutzer ruft Hauptseite auf mit:".$_SERVER['REMOTE_ADDR']);
        }


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

        return view('examples.pages.mainPage', ['data' => $data, 'bilder' => $bilder]  );

    }

}