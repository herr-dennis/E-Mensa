<?php
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

function take_meals(): array
{

    $link = db_anmelden();

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

    return $meals;
}

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

    return $daten;
}

function set_besucheranzahl (){
    $link = db_anmelden();

    $sqp ="UPDATE besucheranzahl SET besucher = besucher +1;";
    mysqli_query($link, $sqp);


}

function get_besucheranzahl() : int {
    $link = db_anmelden();
    $sql ="SELECT besucher FROM besucheranzahl";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['besucher'];
}
