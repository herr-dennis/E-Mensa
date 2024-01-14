<?php
/**
 * @return mysqli Link der Datenbank
 */
function db_anmelden() : mysqli{
    $link = mysqli_connect(
        "localhost", // Host der Datenbank
        "root", // Benutzername zur Anmeldung
        "123", // Passwort zur Anmeldung
        "emensawerbeseite") // Auswahl der Datenbank
    ;
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }


    return $link;
}


function insert_bild($bildname, $id){

    $link = db_anmelden();
    $sql ="UPDATE gericht SET bildname = '$bildname' WHERE id='$id'";

   $result = mysqli_query($link, $sql);

   if($result){
       echo "Bildname erfoglreich eingefügt!";
   }
   else{
       echo mysqli_error($link);
       mysqli_close($link);
   }

}

/**
 * Die über die ID des Benutzers das Passwort zurück, das Passwort
 * ist in sha1 gehashed
 * @param $id, die ID des Benutzers
 * @return mixed|void
 */
function take_pw_by_id($id){

    $link = db_anmelden();
    $sql = "SELECT passwort, salt FROM benutzer WHERE id='$id'";

    mysqli_begin_transaction($link);
    try{

        $result = mysqli_query($link, $sql);
        $pw = array();
        while ( $row = mysqli_fetch_assoc($result)){

            $pw [] = $row;
        }
        if($result){
            mysqli_commit($link);
            return $pw[0]['passwort'];
        }
        else{
            mysqli_rollback($link);
            throw new Exception("Fehler bei: take_pw_by_id ");
        }

    }
    catch (Exception $e){
        //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
    } finally {
        mysqli_close($link);
    }

}

/**
 * Inkrementiert die Anzahl der Anmeldungen des Benutzers
 * @param $id, ID des Benutzers
 */
function set_anzahlanmeldungen($id){

    $link = db_anmelden();
    $sql = "UPDATE benutzer SET anzahlanmeldungen = anzahlanmeldungen +1 WHERE id ='$id'";

     mysqli_begin_transaction($link);
    try{

        $result= mysqli_query($link, $sql);

        if(!$result){
            echo mysqli_error($link);
        }
        else{
            throw new Exception("Fehler set_anzahlfehler");
        }
    }
    catch (Exception $e){
        mysqli_rollback($link);
        error_log($e);
        //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
    } finally {
        mysqli_close($link);
    }


}

/**
 * Setzt den Anmeldezeitpunkt des Benutzers
 * @param $id, ID des Benutzers
 * @param $date, Datum, als der Fehler auftrat
 */
function set_letzteanmeldung($id , $date){

    $link = db_anmelden();
    $sql = "UPDATE benutzer SET letzteanmeldung = '$date' WHERE id = '$id'";

    mysqli_begin_transaction($link);
    try {
        $result= mysqli_query($link, $sql);
        if($result){
            mysqli_commit($link);
        }else{
            throw new Exception("set_letzteanmeldung");
        }
    }
    catch (Exception $exception){
        mysqli_rollback($link);
        error_log("Fehler".$exception->getMessage());
        //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
    } finally {
        mysqli_close($link);
    }

}

/**
 * Gibt den Namen per ID zurück
 * @param $id, ID des Benutzers
 */
function take_name($id) {

    $link = db_anmelden();
    $sql = "SELECT name FROM benutzer WHERE id='$id'";
    mysqli_begin_transaction($link);
    try {
        $result = mysqli_query($link, $sql);

        if($result){
            $row = mysqli_fetch_assoc($result);
            mysqli_commit($link);
            return $row['name'];
        }else{
            throw new Exception("Fehler in take_name");
        }
    }
    catch (Exception $e){
       mysqli_rollback($link);
        error_log($e->getMessage());
        //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
    } finally {
        mysqli_close($link);
    }

}

/**
 * Funktion gibt Daten zum User zurück, nicht das Passwort und Salt!
 * @param $id, ID des Benutzers
 * @return array, das mit User-Daten befüllt ist
 */
function get_all_user($id) :array
{

    $link = db_anmelden();
    $sql = "SELECT id,name,email,admin,anzahlfehler,anzahlanmeldungen,letzteanmeldung, letzterfehler FROM benutzer WHERE id='$id'";

    mysqli_begin_transaction($link);
    try {
        $result = mysqli_query($link, $sql);
        $daten = array();
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $daten[] = $row;
            }
            mysqli_commit($link);
            return $daten;

        } else {
            throw new Exception("Fehler");
        }
    }
   catch (Exception $exception) {
        error_log($exception->getMessage());
        mysqli_rollback($link);
       //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
    } finally {
        mysqli_close($link);
    }
}

/**
 * Funktion die bei einem Fehler das Datum und Zeit speichert
 * @param $id, die ID der angemeldeten Users
 * @param $date, das Datum wo der Fehler auftrat
 */
function set_letzterfehler($id, $date) {
    $link = db_anmelden();
    $sql = "UPDATE benutzer SET letzterfehler = ? WHERE id = ?";

    mysqli_begin_transaction($link);
    try {
        //stmt = statement
        //vorbereitetest Statement
        $pre = mysqli_prepare($link, $sql);
        //Bindet Parameter an das Statement, verhinderung SQL Injection
        mysqli_stmt_bind_param($pre, 'si', $date, $id);
        //Führt das Statement aus, gibt einen Bool zurück
        $result = mysqli_stmt_execute($pre);

        if ($result) {
            mysqli_commit($link);
        } else {
            throw new Exception("Fehler bei der Aktualisierung");
        }
    } catch (Exception $e) {
        echo mysqli_error($link);
        mysqli_rollback($link);
        //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
    } finally {
        mysqli_close($link);
    }
}

/**
 * Imkrementiert die Anzahl der Fehler des Benutzers
 * @param $id, ID des Benutzers
 */
function set_anzahlfeher($id) {
    $link = db_anmelden();
    $sql = "UPDATE benutzer SET anzahlfehler = anzahlfehler + 1 WHERE id = ?";

    mysqli_begin_transaction($link);

    try {
        // Prepared Statement
        $pre = mysqli_prepare($link, $sql);

        // Binding Parameter
        mysqli_stmt_bind_param($pre, 'i', $id);

        // Ausführen des Statements
        $result = mysqli_stmt_execute($pre);

        if ($result) {
            mysqli_commit($link);
        } else {
            throw new mysqli_sql_exception("Fehler bei set_anzahlfehler");
        }
    } catch (mysqli_sql_exception $e) {
        // Logging des Fehlers
        error_log($e);
        //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
    } finally {
        // Schließen der Verbindung
        mysqli_close($link);
    }
}

/**
 * Gibt das zufällige Salt /nicht gehashed aus der DB zurück, über
 * die ID des Benutzers
 * @param $id, ID des Benutzers
 * @return mixed|void
 */
function take_salt_by_id($id){

    $link = db_anmelden();
    $sql = "SELECT salt FROM benutzer WHERE id= '$id'";
    $result =  mysqli_query($link,$sql);
    mysqli_begin_transaction($link);
    try{
        if($result){
            $row = mysqli_fetch_assoc($result);
            mysqli_commit($link);
            return $row['salt'];
        }
        else{
           throw  new Exception("Fehler in take_salt");
        }
    }
    catch (Exception $exception){
        mysqli_rollback($link);
        error_log($exception->getMessage());

        //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
    } finally {
        mysqli_close($link);
    }
}

/**
 * Gibt die ID über die E-Mail des Benutzers zurück
 * @param $email, die E-Mail des Benutzers
 * @return mixed|void
 */
function take_id_user_by_email($email){

    $link = db_anmelden();
    $sql = "SELECT id FROM benutzer WHERE email= '$email'";

     mysqli_begin_transaction($link);
      try{
          $result =  mysqli_query($link,$sql);

          if($result){
              $row = mysqli_fetch_assoc($result);
              return $row['id'];
          }
          else{
              throw  new Exception("Fehler take_id_user_by_email");
          }
      }
      catch (Exception $exception){
          mysqli_rollback($link);
          error_log($exception->getMessage());
          //finally wird auch aufgeführt, wenn wir oben durch return rausspringen!
      } finally {
          mysqli_close($link);
      }


}


/**
 * Gibt das Gericht/Preisintern/Preisextern zurück
 * @return array, Array an Gerichten
 */
function take_meals(): array
{

    $link = db_anmelden();

    $sql = "SELECT name, preisintern, preisextern, bildname FROM gericht";
    $sql_a = "SELECT gericht.name, GROUP_CONCAT(gericht_hat_allergenen.code) AS allergen_codes
FROM gericht
JOIN gericht_hat_allergenen ON gericht.id = gericht_hat_allergenen.gericht_id
GROUP BY gericht.name;";

    $result = mysqli_query($link, $sql);
    $meals = array();


    while ($row = mysqli_fetch_assoc($result)) {
        $meals[] = $row;
    }

    return $meals;
}

/**
 * Gibt ein Array mit den Allergenen zurück
 * @return array
 */
function take_allergens(): array
{

    $link = db_anmelden();

    $sql_a = "SELECT gericht.name, GROUP_CONCAT(gericht_hat_allergenen.code) AS allergen_codes
      FROM gericht
      JOIN gericht_hat_allergenen ON gericht.id = gericht_hat_allergenen.gericht_id
      GROUP BY gericht.name;";

    $result_a = mysqli_query($link, $sql_a);
    $allergens = array();

    while ($row = mysqli_fetch_assoc($result_a)) {
        $allergens[] = $row;
    }
    mysqli_close($link);
    return $allergens;
}
function take_code_allergens() : array{
    $link = db_anmelden();

    $sql = "SELECT code, name FROM allergen";
    $result = mysqli_query($link,$sql);
    $daten = array();

    while($row = mysqli_fetch_assoc($result)){
        $daten[]=$row;
    }
    mysqli_close($link);
    return $daten;
}

function set_besucheranzahl (){
    $link = db_anmelden();

    $sqp ="UPDATE besucheranzahl SET besucher = besucher +1;";
    mysqli_query($link, $sqp);


}





function call_anzahlanmeldungen_procedure($userId) {
    $link = db_anmelden();

    // Rufe die Prozedur auf
    $sql = "CALL increment_anzahlanmeldungen($userId)";
    mysqli_query($link, $sql);

    // Prüfe auf Fehler oder handle sie entsprechend.
    if (mysqli_error($link)) {
        // Fehlerbehandlung
        echo "Fehler beim Aufrufen der Prozedur: " . mysqli_error($link);
    }
}







function get_besucheranzahl() : int {
    $link = db_anmelden();
    $sql ="SELECT besucher FROM besucheranzahl";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($link);
    return $row['besucher'];
}
