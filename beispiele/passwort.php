<?php
include 'C:\Users\herrd\OneDrive\Repository_Dennis\E-Mensa\emensa\models\db_handling.php';


update_pw("SuperPasswort");
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


function create_admin($pw_)
{

    $link = db_anmelden();
    $pw = hashed_pw($pw_);

    $sql = "INSERT INTO benutzer ( name, email, passwort, admin, anzahlfehler, anzahlanmeldungen, letzteanmeldung, letzterfehler, salt) 
            VALUES ( 'SuperAdmin', 'admin@emensa.example', '$pw', 1, 0, 0, NULL, NULL, 'dada')";


    $result = mysqli_query($link, $sql);


    if ($result) {
        // Erfolg
        echo "Superadmin wurde erfolgreich erstellt.";
    } else {
        // Fehler
        echo "Fehler beim Erstellen des Superadmins: " . mysqli_error($link);
    }

    mysqli_close($link);


}


?>
