<?php
/**
 * @return mysqli Link der Datenbank
 */
function db_anmelden() : mysqli{
    $link = mysqli_connect(
        "localhost", // Host der Datenbank
        "root", // Benutzername zur Anmeldung
        "ihesp", // Passwort zur Anmeldung
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


function setRating($userID, $gerichtsID, $text, $sterne) {
    $link = db_anmelden();
    $sql = "INSERT INTO bewertungen (benutzerID, gerichtsID, bewertungstext, sterne) VALUES (?, ?, ?, ?)";

    try {
        $pre = mysqli_prepare($link, $sql);

        if (!$pre) {
            throw new Exception("Vorbereitung des Statements fehlgeschlagen: " . mysqli_error($link));
        }

        mysqli_stmt_bind_param($pre, 'iisd', $userID, $gerichtsID, $text, $sterne);

        $result = mysqli_stmt_execute($pre);

        if (!$result) {
            throw new Exception("Fehler beim Ausführen des Statements: " . mysqli_error($link));
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    } finally {
        mysqli_close($link);
    }
}

function take_mealID_by_name($name){
$link = db_anmelden();

    // Verwende Prepared Statements, um SQL-Injection zu verhindern
    $sql = "SELECT id FROM gericht WHERE name = ?";

    try {
        $pre = mysqli_prepare($link, $sql);

        if (!$pre) {
            throw new Exception("Vorbereitung des Statements fehlgeschlagen: " . mysqli_error($link));
        }

        // Binden des Parameters
        mysqli_stmt_bind_param($pre, 's', $name);

        // Ausführen der Abfrage
        $result = mysqli_stmt_execute($pre);

        if (!$result) {
            throw new Exception("Fehler beim Ausführen des Statements: " . mysqli_error($link));
        }

        // Holen des Ergebnisses
        $row = mysqli_fetch_assoc(mysqli_stmt_get_result($pre));

        // Rückgabe des Ergebnisses
        return $row;

    } catch (Exception $e) {
        // Fehlerbehandlung, zum Beispiel: protokollieren oder an die Anwendung weitergeben
        error_log($e->getMessage());
    } finally {
        // Schließe die Verbindung zur Datenbank
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

function setHighlightRating($ratingID){
    $link = db_anmelden();

    // Überprüfe, ob die Bewertung bereits hervorgehoben ist
    $sqlCheck = "SELECT highlightRating FROM bewertungen WHERE bewertungID = $ratingID";
    $resultCheck = mysqli_query($link, $sqlCheck);

    if ($resultCheck !== false && mysqli_num_rows($resultCheck) > 0) {
        $row = mysqli_fetch_assoc($resultCheck);
        $highlighted = (bool)$row['highlightRating'];

        // Konvertiere den Hervorhebungsstatus in TINYINT (0 oder 1)
        $newHighlightStatus = $highlighted ? 0 : 1;

        // Aktualisiere den Hervorhebungsstatus in der Datenbank
        $sqlUpdate = "UPDATE bewertungen SET highlightRating = $newHighlightStatus WHERE bewertungID = $ratingID";
        $resultUpdate = mysqli_query($link, $sqlUpdate);

        if ($resultUpdate === false) {
            echo "Fehler beim Aktualisieren des Hervorhebungsstatus!";
        }
    } else {
        echo "Bewertung nicht gefunden!";
    }

    mysqli_close($link);
}

function take_rating_meals(){

    $link = db_anmelden();
    $sql ="SELECT gericht.id
FROM gericht
         JOIN bewertungen ON gericht.id = bewertungen.gerichtsID
WHERE bewertungen.highlightRating = 1 ;";

 try {
     $result = mysqli_query($link, $sql);
     if(!$result){
         throw new Exception("Fehler: take:rating_meals");
     }
     else{
         $data= array();
         while ($row= mysqli_fetch_assoc($result)){
             $data[]=$row;
         }
         return $data;
     }

 }
 catch (Exception $exception){
     echo $exception;
 } finally {
     mysqli_close($link);
 }
}

function take_data_for_ratings($id){
    $link = db_anmelden();

       $sql ="SELECT bewertungen.highlightRating , bewertungen.bewertungID, gericht.id, gericht.name, gericht.bildname , bewertungstext ,sterne, bewertungszeitpunkt
FROM gericht
         JOIN bewertungen ON bewertungen.gerichtsID = gericht.id  ORDER BY bewertungszeitpunkt desc ;" ;

         $result = mysqli_query($link,$sql);
    $meals = array();


    while ($row = mysqli_fetch_assoc($result)) {
        $meals[] = $row;
    }
      mysqli_close($link);
    return $meals;


}

function take_data_for_user_rating($id){
    $link = db_anmelden();

    $sql ="SELECT gericht.id, gericht.name, gericht.bildname 
     FROM gericht WHERE id=$id;" ;

    $result = mysqli_query($link,$sql);
    $meals = array();


    while ($row = mysqli_fetch_assoc($result)) {
        $meals[] = $row;
    }
    mysqli_close($link);
    return $meals;


}


function isAdmin($userID){

    $link = db_anmelden();
    $sql = "SELECT admin FROM benutzer WHERE id=$userID";

    try{
        $result = mysqli_query($link,$sql);
        if(!$result){
            throw new Exception("Fehler bei der Funktion isAdmin");
        }
        else{

            $data = mysqli_fetch_assoc($result);

            if($data['admin']==1){
                return true;
            }
        }

    }
    catch (Exception $exception ){
        echo $exception;
        return  false;
    } finally {
        mysqli_close($link);
    }

}

function take_ratings(){
    $link = db_anmelden();

   $sql ="SELECT gericht.id, gericht.name, gericht.bildname , bewertungstext ,sterne, bewertungszeitpunkt
    FROM gericht
         JOIN bewertungen ON bewertungen.benutzerID = gericht.id ORDER BY  bewertungszeitpunkt desc ;" ;

    $result = mysqli_query($link,$sql);
    $meals = array();


    while ($row = mysqli_fetch_assoc($result)) {
        $meals[] = $row;
    }
    mysqli_close($link);
    return $meals;


}
/**
 * Gibt das Gericht/Preisintern/Preisextern zurück
 * @return array, Array an Gerichten
 */
function take_meals(): array
{

    $link = db_anmelden();

    $sql = "SELECT id , name, preisintern, preisextern, bildname FROM gericht";
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


function hashed_pw($pw): string

{
    $salt = take_salt_by_id(1);
    $hashed = sha1($pw.$salt);

    return $hashed;
}



function update_pw($pw_){

    $link = db_anmelden();
    $pw = hashed_pw($pw_);
    $sql ="UPDATE benutzer SET passwort = '$pw' WHERE id=1";
    $result = mysqli_query($link, $sql);
    echo mysqli_error($link);
    if(!$result){

        echo mysqli_error($link);
    }
}

/**
 * Hier habe ich die prepare Statements benutzt, wegen der Get_Methode!
 * @param $erfassungsDatum, löscht die Bewertung, mit genau dem Datum
 * @return bool
 */
function deleteRating($erfassungsDatum)
{
    $link = db_anmelden();


    $sql = "DELETE FROM bewertungen WHERE bewertungszeitpunkt = ?";

    try {
        $stmt = mysqli_prepare($link, $sql);

        // Parameter binden
        mysqli_stmt_bind_param($stmt, 's', $erfassungsDatum);

        // Anweisung ausführen
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
            throw new Exception("Fehler beim Löschen der Bewertung!");
        }
    } catch (Exception $exception) {
        echo $exception;
        return false;
    } finally {
        // Aussage schließen
        mysqli_stmt_close($stmt);

        // Verbindung schließen
        mysqli_close($link);
    }

    return true;
}


function take_rating_for_user($userid){
    $link = db_anmelden();
    $sql = "SELECT DISTINCT  benutzerID, gericht.id, gericht.name, gericht.bildname , bewertungstext ,sterne, bewertungszeitpunkt
            FROM gericht
            JOIN bewertungen ON bewertungen.gerichtsID = gericht.id  join benutzer on bewertungen.benutzerID = $userid";

    try{

        $result = mysqli_query($link, $sql);
        $data = array();
        if(!$result){
            throw new Exception("Fehler in take_rating_for_user");
        }else{


            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }


        }
    }
    catch (Exception$exception){
        echo $exception;
    } finally {
        mysqli_close($link);
    }
    return $data;

}

function create_user($pw_, $name, $email)
{
    $salt ='Dadada2';
    $link = db_anmelden();
    $hashed = sha1($pw_.$salt);

    $sql = "INSERT INTO benutzer (name, email, passwort, admin, anzahlfehler, anzahlanmeldungen, letzteanmeldung, letzterfehler, salt) 
            VALUES (?, ?, ?, 0, 0, 0, NULL, NULL, ?)";

    $pre = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($pre, 'ssss', $name, $email, $hashed, $salt);

    $result = mysqli_stmt_execute($pre);

    if ($result) {
        // Erfolg
        echo "Superadmin wurde erfolgreich erstellt.";
    } else {
        // Fehler
        echo "Fehler beim Erstellen des Superadmins: " . mysqli_error($link);
    }

    mysqli_close($link);
}







function get_besucheranzahl() : int {
    $link = db_anmelden();
    $sql ="SELECT besucher FROM besucheranzahl";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($link);
    return $row['besucher'];
}
