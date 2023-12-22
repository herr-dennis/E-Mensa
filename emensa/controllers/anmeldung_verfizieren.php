

<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/emensa/models/db_handling.php');
session_start();

//try {
    /**
     * Überprüft, ob die Eingabedaten leer sind, wenn ja → Nachricht wird in Session geschrieben.

    if (!empty($_POST['email_input']) && !empty($_POST['pw_input'])) {
        $email = htmlspecialchars($_POST['email_input']) ;
        $pw =  htmlspecialchars($_POST['pw_input']) ;
        $log = logger('info');
        $log->info("Angemeldet!");
        // Versuche, die Benutzer-ID zu erhalten
        $id = take_id_user_by_email($email);
        //Formtat: Year/Monat/Day/Stunde/minuten/sekunden
        $date = date("Y-m-d H:i:s");
        // Falls erfolgreich, hole das Passwort und speichere es in der Session
        $storedpassword = take_pw_by_id($id);
        echo $storedpassword;
        //Holt der zufällig generierte Salt aus der DB per ID
        $salt = take_salt_by_id($id);
        //Hashed das eingegebene Passwort, um es vergleichen zu können
        $input_pw = sha1($pw.$salt);

        if($storedpassword===$input_pw){

            $_SESSION['login'] =true;
            $_SESSION['error_msg']="";
            $_SESSION['name']= take_name($id);
            $_SESSION['id']= $id;
            set_letzteanmeldung($id,$date );
            set_anzahlanmeldungen($id);
            set_anzahlfeher($id);
            header('Location:/emensa/public/');
            exit();
        }else{
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
exit(); */

