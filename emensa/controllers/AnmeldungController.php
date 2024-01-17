<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/db_handling.php');
class  AnmeldungController{

    public function anmeldung()
    {

        if(empty($_SESSION['name'])){
            $_SESSION['name']="Nicht angemeldet";
        }
       return view('examples.pages.anmeldung');
    }



    public function ver(){

        try {
            /**
             * Überprüft, ob die Eingabedaten leer sind, wenn ja → Nachricht wird in Session geschrieben.
             */
            if (!empty($_POST['email_input']) && !empty($_POST['pw_input'])) {
                $email = htmlspecialchars($_POST['email_input']) ;
                $pw =  htmlspecialchars($_POST['pw_input']) ;

                // Versuche, die Benutzer-ID zu erhalten
                $id = take_id_user_by_email($email);
                //Formtat: Year/Monat/Day/Stunde/minuten/sekunden
                $date = date("Y-m-d H:i:s");
                // Falls erfolgreich, hole das Passwort und speichere es in der Session
                $storedpassword = take_pw_by_id($id);
                //Holt der zufällig generierte Salt aus der DB per ID
                $salt = take_salt_by_id($id);
                //Hashed das eingegebene Passwort, um es vergleichen zu können
                $input_pw = sha1($pw.$salt);
                //Speichert den Namen
                $_SESSION['name']= take_name($id);

                if($storedpassword===$input_pw){
                    $_SESSION['login'] =true;
                    $_SESSION['error_msg']="";
                    $_SESSION['id']= $id;
                    set_letzteanmeldung($id,$date );
                    call_anzahlanmeldungen_procedure($id);
                    //set_anzahlfeher($id);
                    $log = logger('info');
                    $log->info($_SESSION['name']." hat sich eingeloggt");

                    if($_SESSION['comeFrom']==='bewertung'){
                        header('Location:/emensa/public/bewertungen');
                        exit();
                    }
                    elseif ($_SESSION['comeFrom']==='meineBewertung'){
                        header('Location:/emensa/public/meineBewertung');
                        exit();
                    }
                    else{
                        header('Location:/emensa/public/');
                        exit();
                    }

                }else{
                    set_anzahlfeher($id);
                    $log = logger('warning');
                    $log->warning($_SESSION['name']." fehlgeschlagener Logging!");
                    set_letzterfehler($id, $date);
                    $_SESSION['error_msg'] = "Passwort oder Email falsch!";
                }


            } else {
                // Eingabedaten sind leer
                $_SESSION['error_msg'] = "Passwort oder Email falsch!";
            }
        } catch (Exception $e) {

            set_letzterfehler($id, $date);

            $_SESSION['error_msg'] = "Fehler beim Abrufen der Benutzer-ID.";
        }

        header('Location:/emensa/public/anmeldung');
        exit();
    }

 public function abmelden (){

     if(isset($_SESSION['login'])){
         if ($_SESSION['login']===true){
             $_SESSION['login'] = false;
             $log = logger('info');
             $log->warning($_SESSION['name']." hat sich abgemeldet!");
             session_destroy();
             header('Location:/emensa/public/');
             exit();
         }
     }



 }
 public function reg(){


        if(isset($_POST['name'])){
         var_dump($_POST);
            create_user($_POST['password'],$_POST['name'], $_POST['email']);

        }


      return view('examples.pages.reg');

 }

}






