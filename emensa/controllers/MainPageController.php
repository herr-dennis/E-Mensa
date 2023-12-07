<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/db_handling.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/take_img.php');
class MainPageController
{

    public  function mainPageController(){
        $email=false;
        $name_validate = false;
        $default = true;

        $data = take_meals();
        $bilder = take_img(count($data)+7);

        /**

        if(!empty($_POST[GET_Checked])) {
            if ($_GET['pushed'] = 'Datensenden') {
                if (!empty($_POST[GET_NAME])) {
                    $name_text = trim($_POST[GET_NAME]);
                    $lang_text = $_POST[GET_LANG];
                    $lang_text = htmlspecialchars($lang_text);
                    $name_text =htmlspecialchars($name_text);
                    if (strlen($name_text != 0)) {
                        $name_validate = true;
                        $default = false;
                    }
                }
                if (!empty($_POST[GET_EMAIL])) {
                    $email_text = $_POST[GET_EMAIL];
                    $email_text = htmlspecialchars($email_text);
                    if (filter_var($email_text, FILTER_VALIDATE_EMAIL)) {

                        $email = true;
                        $default = false;

                    }
                }
            }
        }   */

        return view('examples.pages.mainPage', ['data' => $data, 'bilder' => $bilder]  );

    }


}