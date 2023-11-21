<?php



function take_meals() : array{

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


    $sql = "SELECT name, preisintern, preisextern FROM gericht";
    $sql_a = "SELECT gericht.name, GROUP_CONCAT(gericht_hat_allergenen.code) AS allergen_codes
FROM gericht
JOIN gericht_hat_allergenen ON gericht.id = gericht_hat_allergenen.gericht_id
GROUP BY gericht.name;";

    $result = mysqli_query($link, $sql);
    $meals = array();


    while ($row = mysqli_fetch_assoc($result)) {
        $meals[] = $row;
    }

       return  $meals;
}

function take_allergens() : array{

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

    $sql_a = "SELECT gericht.name, GROUP_CONCAT(gericht_hat_allergenen.code) AS allergen_codes
      FROM gericht
      JOIN gericht_hat_allergenen ON gericht.id = gericht_hat_allergenen.gericht_id
      GROUP BY gericht.name;";

    $result_a = mysqli_query($link, $sql_a);
    $allergens = array();

    while ($row = mysqli_fetch_assoc($result_a)){
        $allergens[] =$row;}

    return $allergens;
}
