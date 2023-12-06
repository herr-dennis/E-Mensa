<?php
include "db_handling.php";
$aktuellesDatum = date('Y-m-d H:i:s');
$name = isset($_POST['name']) ? $_POST['name'] : "anonymus";

// Verwaltung des Wunschgerichtes
if (!empty($_POST['abgeschickt'])) {
    if (!empty($_POST['email']) && !empty($_POST['beschreibung']) && !empty($_POST['name_gericht'])) {
        $link = db_anmelden();
        $email = $_POST['email'];
        $beschreibung = $_POST['beschreibung'];
        $gericht_name = $_POST['name_gericht'];

        $email = mysqli_real_escape_string($link, $email);
        $name = mysqli_real_escape_string($link, $name);
        $beschreibung = mysqli_real_escape_string($link, $beschreibung);
        $gericht_name = mysqli_real_escape_string($link, $gericht_name);

        // Überprüfe, ob die E-Mail bereits existiert
        $email_check = mysqli_query($link, "SELECT * FROM ersteller WHERE email='$email'");

        if (mysqli_num_rows($email_check) == 0) {
            // Ersteller existiert noch nicht, füge ihn hinzu
            $sql_ersteller = "INSERT INTO ersteller (email, ersteller_name) VALUES ('$email', '$name')";

            if (mysqli_query($link, $sql_ersteller)) {
                echo "Ersteller-Datensatz erfolgreich eingefügt.";
            } else {
                echo "Fehler beim Einfügen des Ersteller-Datensatzes: " . mysqli_error($link);
            }
        }

        // Wunschgericht-Datensatz einfügen
        $sql_wunschgericht = "INSERT INTO wunschgericht (gericht_name, beschreibung, erfassung_datum, ersteller_mail)
                              VALUES ('$gericht_name', '$beschreibung', '$aktuellesDatum', '$email')";

        if (mysqli_query($link, $sql_wunschgericht)) {
            echo "Wunschgericht-Datensatz erfolgreich eingefügt.";
        } else {
            echo "Fehler beim Einfügen des Wunschgericht-Datensatzes: " . mysqli_error($link);
        }
    } else {
        echo "Bitte fülle alle Felder aus.";
    }
}
?>






<!DOCTYPE html>
<html lang="de">
<head>
    <title>Wunschgericht</title>
    <meta charset="UTF-8">

    <style>
        form{
            display: flex;
            flex-direction: column;

            align-content: center;
            justify-content: center;

        }
        main{
            display: grid;
            place-content:center;

        }

        * {

            font-family: "Papyrus", cursive, sans-serif;

        }
    </style>

</head>

<body>

<main>

     <h1>Ihre E-Mensa</h1>
    <form name="form_wunsch" action="wunschgericht.php" method="post">
        <label for="name_input">Ihr Namen:</label>
        <input id="name_input" type="text" name="name" value="Hier Ihren Namen eingeben">
        <br>
        <label for="beschreibung_input">Ihr Wunschgericht:</label>
        <input id="beschreibung_input" name="name_gericht" value="Ihr Wunschgericht" >

        <label for="beschreibung_input">Beschreibung Ihres Gerichtes</label>
        <input id="beschreibung_input" name="beschreibung" value="Beschreibung" >
        <label for="email_input" > E-Mail:</label>
        <input id="email_input" name="email" value="Bitte Ihre Email eintragen" required>
        <br>
        <input type="submit" name="abgeschickt" value="Ihr Wunsch abschicken!">
        <input type="button" name="back" value="Zur Hauptseite" onclick="back_()">

        <script>
            function back_(){
                window.location.href ="index.php"
            }
        </script>
    </form>

</main>
<footer>

</footer>
</body>

</html>
